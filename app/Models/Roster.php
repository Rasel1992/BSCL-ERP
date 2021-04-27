<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable = [
        'user_id',
        'shift_id',
        'roster_date',
        'day',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
