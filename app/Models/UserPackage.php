<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
	use SoftDeletes;
    protected $table = 'user_packages';

	protected $fillable = [
	   'user_id', 'package_id', 'subscription_end_date'
	];

	//hasOne relation with Package Model
	public function package(){
	    return $this->hasOne(Package::class, 'id', 'package_id');
	}

	//hasOne relation with User Model
	public function user(){
	    return $this->hasOne(User::class, 'id', 'user_id');
	}
}