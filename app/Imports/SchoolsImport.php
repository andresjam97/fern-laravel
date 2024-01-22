<?php

namespace App\Imports;

use App\Models\Employe;
use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $employeeIdentifier = $row[1];


        $employee = Employe::where('id', $employeeIdentifier)->first();

        return new School([
            'name'     => $row[0],
            'employe_id'     => $employee->id,
        ]);
    }
}
