<?php

namespace App\Imports;

use App\Models\Game\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
            'question' => $row[0],
            'option_a' => $row[1],
            'option_b' => $row[2],
            'option_c' => $row[3],
            'option_d' => $row[4],
            'correct_option' => $row[5],
            'level' => $row[6]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
