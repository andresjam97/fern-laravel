<?php

namespace App\Http\Controllers;

use App\Imports\QuestionImport;
use App\Models\Game\Game;
use App\Models\Game\LeaderBoardQqsm;
use App\Models\Game\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class QqsmController extends Controller
{
    function index() {
        return view('QQSM.index');
    }


    public function reloadPreviousGame()
    {
        $lastGame = Game::belongsToUser()->latest()->first();

        if(!isset($lastGame) || $lastGame->status != 'EN JUEGO') {
            return response()->json(["message" => "No existen juegos abiertos"]);
        }

        $currentQuestion = $lastGame->questions()->orderByPivot("created_at", "desc")->first();
        $lastGame->loadCount("questions");

        $rank = LeaderBoardQqsm::where('id_user', auth()->id())->first();
        $accuracy = ($rank?->accuracy ?? 0) * 100;

        return response()->json([
            'id' => $lastGame->id,
            'question' => [
                'id' => $currentQuestion->id,
                "question" => $currentQuestion->question,
                'option_a' => $currentQuestion->option_a,
                'option_b' => $currentQuestion->option_b,
                'option_c' => $currentQuestion->option_c,
                'option_d' => $currentQuestion->option_d,
            ],
            "score" => $lastGame->score,
            "level" => ceil($lastGame->current_level),
            'rank_score' => $rank?->rnk_score ?? 0,
            'rank_accuracy' => "$accuracy%",
        ]);
    }

    public function startNewGame()
    {
        $lastGame = Game::belongsToUser()->latest()->first();

        if(isset($lastGame) && $lastGame->status == 'EN JUEGO') {
            return response()->json(["message" => "Ya existe un juego en curso"], status: 400);
        }

        try {
            DB::beginTransaction();

            $score = 0;

            if(isset($lastGame)) {
                $score = $lastGame->score;
            }

            $game = Game::create([
                'id_user' => auth()->id(),
                "status" => 'EN JUEGO',
                'score' => $score,
            ]);

            $nextQuestion = $this->getNextQuestion($game);

            if(is_string($nextQuestion)) {
                DB::rollBack();
                return response()->json(["message" => "Error al asociar la primera pregunta"]);
            }

            DB::commit();

            $rank = LeaderBoardQqsm::where('id_user', auth()->id())->first();
            $accuracy = ($rank?->accuracy ?? 0) * 100;

            return response()->json([
                'game_id' => $game->id,
                "question" => $nextQuestion,
                "score" => $game->score,
                "level" => 1,
                'rank_score' => $rank?->rnk_score ?? 0,
                'rank_accuracy' => "$accuracy%",
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return response()->json(["message" => "Error iniciando una nueva partida"], status: 400);
        }
    }

    private function getNextQuestion(Game $game) : Question | string
    {
        $game->loadCount("questions");
        $currentLevel = is_int($game->current_level) ? $game->current_level + 1 : ceil($game->current_level);

        $nextQuestion = Question::select("questions.id", "question", "option_a", "option_b", "option_c", "option_d")
            ->where('level', $currentLevel)
            ->leftJoin("questions_games as qg", "questions.id", "=", "qg.id_question")
            ->where(function($q) use ($game) {
                $q->whereNull('qg.id_game')->orWhere('qg.id_game', '<>', $game->id);
            })
            ->inRandomOrder()
            ->first();

        if(!$nextQuestion) {
            return "no hay más preguntas disponibles";
        }

        $game->questions()->attach($nextQuestion->id);

        return $nextQuestion;
    }

    public function checkAnswer(Request $request, Game $game)
    {
        if($game->status != 'EN JUEGO') {
            return response()->json(["message" => "El juego ya finalizó."]);
        }

        $selectedOption = $request->input('selected_option');
        $currentQuestion = $game->questions()->orderByPivot("created_at", "desc")->first();
        $isCorrect = $currentQuestion->correct_option == $selectedOption;

        $game->loadCount("questions");

        if(!$isCorrect) {
            $game->status = 'JUEGO CERRADO';
            $game->accuracy = ($game->questions_count - 1) / 15;
            $game->score = $game->score - $game->questions->filter(function ($q) use ($currentQuestion) {
                return $q->level == $currentQuestion->level;
            })->skip(1)->sum('score');
            $game->save();

            return response()->json([
                'correct_option' => $currentQuestion->correct_option,
                'game_status' => $game->status,
            ]);
        }

        $game->updateScore($currentQuestion);

        if($game->questions_count == 15) {
            $game->status = "JUEGO GANADO";
            $game->accuracy = 1;
            $game->save();

            return response()->json([
                'correct_option' => $currentQuestion->correct_option,
                'game_status' => $game->status,
            ]);
        } else {
            DB::beginTransaction();
            $nextQuestion = $this->getNextQuestion($game);

            if(is_string($nextQuestion)) {
                DB::rollBack();
                return response()->json(["message" => "No hay suficientes preguntas"], status: 500);
            }

            $game->save();
            DB::commit();

            $game->loadCount("questions");

            return response()->json([
                'correct_option' => $currentQuestion->correct_option,
                'game_status' => $game->status,
                'next_question' => $nextQuestion,
                'score' => $game->score,
                "level" => ceil($game->current_level),
            ]);
        }
    }

    public function ranksByScore()
    {
        $ranks = LeaderBoardQqsm::select('name', 'rnk_score')
        ->where(function($q) {
            $q->where('rnk_score', '<=', 10)
                ->orWhere('id_user', auth()->id());
        })
        ->orderBy('rnk_score', 'asc')
        ->get();

        return DataTables::of($ranks)
            ->make(true);
    }

    public function ranksByAccuracy()
    {
        $ranks = LeaderBoardQqsm::select('name', 'rnk_accuracy')
        ->where(function($q) {
            $q->where('rnk_accuracy', '<=', 10)
                ->orWhere('id_user', auth()->id());
        })
        ->orderBy('rnk_accuracy', 'asc')
        ->get();

        return DataTables::of($ranks)
            ->make(true);
    }

    public function importQuestions(Request $request)
    {
        $request->validate([
            'adjunto' => 'required|file',
        ]);

        try {
            Excel::import(new QuestionImport, $request->file("adjunto"));
            Alert::success("Preguntas importadas correctamente");
        } catch (\Throwable $th) {
            Log::error($th);
            Alert::error("Error al importar las preguntas.");
        }
    }


    function questionsImportForm(){
        return view('importadores.questions.questions-import');
    }

    function createQuestionVw() {
        return view('QQSM.questions-create');
    }

    function createQuestion(Request $request) {
        try {
            $pregunta = new Question();
            $pregunta->question = $request->question;
            $pregunta->option_a = $request->option_a;
            $pregunta->option_b = $request->option_b;
            $pregunta->option_c = $request->option_c;
            $pregunta->option_d = $request->option_d;
            $pregunta->correct_option = $request->correct_option;
            $pregunta->level = $request->level;
            $pregunta->save();

            return back()->with('message', 'Pregunta creada con exito!');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }

    }

    function truncate(Request $request) {
        $questions = Question::truncate();
        return back()->with('truncate', 'Preguntas vaciadas');
    }
}
