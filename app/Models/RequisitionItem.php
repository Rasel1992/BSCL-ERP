<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    protected $fillable = [
        'requisition_id',
        'item_code',
        'particulars',
        'qty',
        'disbursement',
    ];
}
