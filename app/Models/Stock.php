<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'stock_code',
        'description',
        'category_id',
        'qty',
        'location',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
