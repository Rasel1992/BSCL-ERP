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
            'category_id'    => $row[3],
            'user_id'    => $row[4],
            'dept_id'    => $row[5],
            'voucher_no'    => $row[6],
            'qty'    => $row[7],
            'cost'    => $row[8],
            'location'    => $row[9],
            'purchase_date'    => $row[10],
        ]);
    }
}
