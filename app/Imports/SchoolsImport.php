<?php

namespace App\Imports;

use App\Models\Employe;
use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SchoolsImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $employeeIdentifier = $row[1];


        $employee = Employe::where('name', 'like','%'.$employeeIdentifier.'%')->first();

        return new School([
            'name'     => $row[0],
            'employe_id'     => $employee->id,
        ]);
    }


    public function startRow(): int
    {
        return 2;
    }
}
