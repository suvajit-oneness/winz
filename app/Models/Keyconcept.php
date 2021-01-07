<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyconcept extends Model
{
	use SoftDeletes;
    protected $table = 'key_conceptes';

	protected $fillable = [
	   'board_id', 'class_id','subject_id','title','description','image','video_link','is_active'
	];

	public $timestamps = false;
    
    // has one board
	public function board(){
	    return $this->hasOne(Board::class, 'id', 'board_id');
	}
    // has one subject
	public function subject(){
	    return $this->hasOne(Subject::class, 'id', 'subject_id');
	}
    // has one topic
	public function class(){
	    return $this->hasOne(Classes::class, 'id', 'class_id');
	}
}
