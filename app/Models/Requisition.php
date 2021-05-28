<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Requisition extends Model
{
    use SoftDeletes, LogsActivity;
    protected $fillable = [
        'sl_number',
        'requisition_to',
        'verified_to',
        'approved_to',
        'received_to',
        'disbursed_to',
        'requisition_by',
        'verified_by',
        'approved_by',
        'received_by',
        'disbursed_by',
        'actual_user',
        'requisition_date',
        'requisition_by_sign',
        'verified_status',
        'approved_status',
        'received_status',
        'disbursed_status',
        'status',
        'comment',
    ];

    public function requisitionItems()
    {
        return $this->hasMany('App\Models\RequisitionItem');
    }
    public function requisitionBy(){
        return $this->belongsTo('App\User', 'requisition_by', 'id');
    }
    public function verifiedBy(){
        return $this->belongsTo('App\User', 'verified_by', 'id');
    }
    public function approvedBy(){
        return $this->belongsTo('App\User', 'approved_by', 'id');
    }
    public function receivedBy(){
        return $this->belongsTo('App\User', 'received_by', 'id');
    }
    public function disbursedBy(){
        return $this->belongsTo('App\User', 'disbursed_by', 'id');
    }

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Requisition'; //custom_log_name_for_this_model

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }
}
