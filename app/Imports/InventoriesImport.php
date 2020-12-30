<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class InventoriesImport implements ToModel, WithValidation
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
        ]);
    }
    public function rules(): array
    {
        return [
            '1' => 'required|string',
            '2' => 'nullable|string',
            '3' => 'required|integer',
            '4' => 'required|string',
            '5' => 'nullable|integer',
            '6' => 'nullable|integer',
            '7' => 'nullable|string',
            '8' => 'nullable|numeric',
            '9' => 'nullable|numeric',
            '10' => 'required|string',
            // so on
        ];
    }
}
