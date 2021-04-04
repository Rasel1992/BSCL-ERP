<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockUser extends Model
{
    protected $fillable = [
        'stock_id',
        'assign_to',
        'user_id',
        'dept_id',
        'qty',
        'assign_date',
    ];

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock', 'stock_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\user', 'user_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'dept_id', 'id');
    }
}
