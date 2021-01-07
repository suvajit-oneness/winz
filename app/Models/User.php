<?php

namespace App\Models;

use App\Notifications\UserResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
	use Notifiable;use SoftDeletes;

    protected $table = 'users';

	protected $fillable = [
	   'name', 'mobile', 'email','membership_id', 'otp','password', 'country', 'city', 'address', 'is_active'//, 'is_deleted'
	];

	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	
    protected $hidden = [
        'password', 'remember_token',
    ];

	public $timestamps = false;

	public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function membership(){
        return $this->hasOne(Membership::class, 'id', 'membership_id');
    }

    public function creditlist(){
        return $this->hasMany(Creditlist::class);
    }
}
