<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class StockUser extends Model
{
    use SoftDeletes, LogsActivity;
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

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Stock User'; //custom_log_name_for_this_model

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }
}
