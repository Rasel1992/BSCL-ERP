<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillRegister extends Model
{
    protected $fillable = [
        'bill_date',
        'bill_no',
        'shop_info',
        'invoice_number',
        'invoice_date',
        'item_name',
        'subject',
        'quantity',
        'cost',
        'location',
        'assign_to',
        'qr_code',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
