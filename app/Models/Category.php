<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id','category_name', 'type',
    ];

    public function nested()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function items()
    {
        return $this->nested()->select('id', 'parent_id', 'category_name');
    }
    public function inventories() {
        return $this->hasMany('App\Models\Inventory', 'category_id', 'id');
    }

    public function stocks() {
        return $this->hasMany('App\Models\Stock', 'category_id', 'id');
    }

}
