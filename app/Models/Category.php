<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use SoftDeletes, LogsActivity;
    protected $fillable = [
        'parent_id', 'category_name', 'type', 'category_code'
    ];

    public function nested()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
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
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }
    public function inventories() {
        return $this->hasMany('App\Models\Inventory', 'category_id', 'id');
    }

    public function stocks() {
        return $this->hasMany('App\Models\Stock', 'category_id', 'id');
    }

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Category'; //custom_log_name_for_this_model

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }

}
