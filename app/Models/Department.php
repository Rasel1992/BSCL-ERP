<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department',
        'designation',
    ];

    public function stocks() {
        return $this->hasMany(StockUser::class, 'dept_id', 'id');
    }
}
