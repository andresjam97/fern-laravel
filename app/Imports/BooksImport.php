<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BooksImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $schoolIdentifier = $row[2];


        $school = School::where('name', 'like','%'.$schoolIdentifier.'%')->firstOrFail();

        return new Book([
            'name'     => $row[0],
            'price'     => $row[1],
            'id_school' =>$school->id
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
