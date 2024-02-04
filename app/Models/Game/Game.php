<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'score' => 'int',
    ];

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            "questions_games",
            'id_game',
            "id_question",
        )->withTimestamps();
    }

    public function scopeBelongsToUser($q)
    {
        $q->where('id_user', auth()->id());
    }

    protected function currentLevel() : Attribute
    {
        return Attribute::make(get: fn() => $this->questions_count / 5);
    }

    public function updateScore(Question $question)
    {
        $this->score += $question->score;
    }
}
