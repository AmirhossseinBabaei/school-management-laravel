<?php

namespace App\Imports;

use Maatwebsite\Excel\Excel;

class StudentsImport
{
    public function toModel($file)
    {
        $data = Excel::toArray([], $file);

        foreach ($data as $row) {

        }
    }
}
