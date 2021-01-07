<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionpaper extends Model
{
	use SoftDeletes;
    protected $table = 'question_papers';

	protected $fillable = [
	   'board_id', 'class_id','subject_id','title','description','image','video_link','is_active','difficulty','video_solution','video_solution2','video_solution3'
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
