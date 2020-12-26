<?php

namespace App\Imports;

use App\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class SalesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Sale([
            'asset_code'          => $row['asset_code'],
            'details'            => $row['details'],
            'category'           => $row['category'],
            'date'                => $row['date'],
            'invoice'            => $row['invoice'],
            'qty'                 => $row['qty'],
            'cost'               => $row['cost'],
            'allocated_to'       => $row['allocated_to']
        ]);
    }
}
