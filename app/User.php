<?php

namespace App;
use App\Models\Department;
use App\Models\Inventory;
use App\Models\StockUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'email', 'mobile', 'password','dob',
        'sex', 'dept_id', 'designation', 'image', 'joining_date',
        'joining_date', 'father_name',  'mother_name', 'blood_group',
        'nid', 'passport', 'present_address', 'permanent_address', 'signature'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stocks() {
        return $this->hasMany(StockUser::class, 'user_id', 'id');
    }

    public function inventories() {
        return $this->hasMany(Inventory::class, 'user_id', 'id');
    }

    public function departments() {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }
}
