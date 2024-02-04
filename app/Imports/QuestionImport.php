<?php

namespace App\Imports;

use App\Models\Game\Question;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionImport implements ToModel,
    WithMapping,
    WithValidation,
    SkipsEmptyRows,
    WithBatchInserts,
    WithChunkReading
{
    public function model(array $row)
    {
        return new Question($row);
    }

    public function rules(): array
    {
        return [
            'question' => "required|string",
            'option_a' => "required|string",
            'option_b' => "required|string",
            'option_c' => "required|string",
            'option_d' => "required|string",
            'correct_option' => "required|in:a,b,c,d",
            'level' => "required|in:1,2,3",
        ];
    }

    public function map($row): array
    {
        return [
            'question' => $row[0],
            'option_a' => $row[1],
            'option_b' => $row[2],
            'option_c' => $row[3],
            'option_d' => $row[4],
            'correct_option' => $row[5],
            'level' => $row[6],
            'perfil' => $row[7],
            'linea' => $row[8],
        ];
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function chunkSize(): int
    {
        return 400;
    }
}
