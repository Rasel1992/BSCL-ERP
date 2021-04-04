<?php

namespace App\Imports;

use App\Models\Inventory;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class InventoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /**
     * Transform a date value into a Carbon object.
     *
     * @return Inventory
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    public function model(array $row)
    {
        return new Inventory([
            'id' => $row[0],
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
            'purchase_date' => $this->transformDate($row[11]),
            'assign_date' => $this->transformDate($row[12]),
        ]);
    }

//    public function rules(): array
//    {
//        return [
//            '1' => 'required|string',
//            '2' => 'nullable|string',
//            '3' => 'required|integer',
//            '4' => 'required|string',
//            '5' => 'nullable|integer',
//            '6' => 'nullable|integer',
//            '7' => 'nullable|string',
//            '8' => 'nullable|numeric',
//            '9' => 'nullable|numeric',
//            '10' => 'required|string',
//            '11' => 'nullable|string',
//            // so on
//        ];
//    }
}
