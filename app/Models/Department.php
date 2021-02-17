<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department',
    ];

    public function stocks() {
        return $this->hasMany(StockUser::class, 'dept_id', 'id');
    }

    public function inventories() {
        return $this->hasMany(Inventory::class, 'user_id', 'id');
    }
}
