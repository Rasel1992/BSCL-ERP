<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
