<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'parent_id', 'category_name', 'type', 'category_code'
    ];

    public function nested()
    {
        return $this->hasMany('App\Models\StockCategory', 'parent_id', 'id');
    }

    public function items()
    {
        return $this->nested()->select('id', 'parent_id', 'category_name');
    }
    /**
     * Get the parent of the category.
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\StockCategory', 'parent_id');
    }
    public function stocks() {
        return $this->hasMany('App\Models\Stock', 'category_id', 'id');
    }
}
