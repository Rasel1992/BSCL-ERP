<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportStock implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
            'id'     => $row[0],
            'description'     => $row[1],
            'category_id'    => $row[2],
            'qty'    => $row[3],
            'location'    => $row[4],
        ]);
    }
}
