<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;

class InventoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Inventory([
            'asset_code'     => $row[1],
            'description'    => $row[2],
            'voucher_no'    => $row[3],
            'purchase_date'    => $row[4],
            'qty'    => $row[5],
            'cost'    => $row[6],
            'location'    => $row[7],
            'category_id'    => $row[8],
            'user_id'    => $row[9],
            'dept_id'    => $row[10],
        ]);
    }
}
