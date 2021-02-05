<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'asset_code',
        'description',
        'category_id',
        'assign_to',
        'user_id',
        'dept_id',
        'voucher_no',
        'qty',
        'cost',
        'location',
        'purchase_date',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'dept_id', 'id');
    }
}
