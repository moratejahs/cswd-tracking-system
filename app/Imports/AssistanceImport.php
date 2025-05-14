<?php

namespace App\Imports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssistanceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Assistance([
            'first_name'     => $row['first_name'],
            'middle_name'    => $row['middle_name'],
            'last_name'      => $row['last_name'],
            'birth_date'     => $row['birth_date'],
            'age'            => $row['age'],
            'gender'         => $row['gender'],
            'address'        => $row['address'],
            'contact_no'     => $row['contact_no'],
            'occupation'     => $row['occupation'],
            'purpose'        => $row['purpose'],
            'category_id'    => $row['category'],
            'amount'         => $row['amount'],
            'responsible_person' => $row['responsible_person'],
        ]);
    }
}
