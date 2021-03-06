<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class InventoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::select('id', 'asset_code', 'description', 'category_id', 'assign_to', 'user_id', 'dept_id', 'voucher_no', 'qty', 'cost', 'location', 'purchase_date')->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Asset Code',
            'Description',
            'Category',
            'Allocate To',
            'User',
            'Department',
            'Voucher No',
            'Qty',
            'Cost',
            'Location',
            'Purchase Date',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12.5);
            },
        ];
    }
}
