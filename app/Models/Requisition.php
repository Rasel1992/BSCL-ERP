<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $fillable = [
        'sl_number',
        'requisition_to',
        'requisition_by',
        'actual_user',
        'requisition_date',
        'requisition_by_sign',
        'verified_by',
        'approved_by',
        'received_by',
        'disbursed_by',
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
}
