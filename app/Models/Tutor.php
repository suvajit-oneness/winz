<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutor extends Model
{
	use SoftDeletes;
    protected $table = 'tutors';

	protected $fillable = [
	   'board_id', 'subject_id','topic_id','name','email','image','mobile','is_active'
	];

	public $timestamps = false;

	public function board(){
	    return $this->hasOne(Board::class, 'id', 'board_id');
	}

	public function subject(){
	    return $this->hasOne(Subject::class, 'id', 'subject_id');
	}

	public function topic(){
	    return $this->hasOne(Topic::class, 'id', 'topic_id');
	}
}
