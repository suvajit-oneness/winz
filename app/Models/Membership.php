<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
	use SoftDeletes;
    protected $table = 'memberships';

	protected $fillable = [
	   'id', 'title','description','price','is_active'
	];

	public $timestamps = false;
	
	// has many user
	public function user(){
		return $this->hasMany(User::class, 'membership_id', 'id');
	}

	function question(){
		return $this->hasMany('App\Models\CommonQuestion','membership_id','id');
	}
}
