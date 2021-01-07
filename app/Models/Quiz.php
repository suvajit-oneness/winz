<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
	use SoftDeletes;
    protected $table = 'quizzes';

	protected $fillable = [
	   'board_id', 'class_id','subject_id','question','option1','option2','option3','option4','option5','answer','is_active'
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
    // has one class
	public function class(){
	    return $this->hasOne(Classes::class, 'id', 'class_id');
	}
}
