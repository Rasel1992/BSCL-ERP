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
            'assign_to'    => $row[4],
            'user_id'    => $row[5],
            'dept_id'    => $row[6],
            'voucher_no'    => $row[7],
            'qty'    => $row[8],
            'cost'    => $row[9],
            'location'    => $row[10],
            'purchase_date'    => $row[11],
        ]);
    }
}
