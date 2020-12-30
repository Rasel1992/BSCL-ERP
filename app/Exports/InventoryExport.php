<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;

class InventoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::select('asset_code', 'description', 'category_id', 'assign_to', 'user_id', 'dept_id', 'voucher_no', 'qty', 'cost', 'location', 'purchase_date')->get();
    }
}
