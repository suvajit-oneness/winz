<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    function chapter(){
    	return $this->belongsTo('App\Models\Chapter','chapterId','id');
    }
    
    function subjectCategory(){
    	return $this->belongsTo('App\Models\SubjectCategory','subjectCategoryId','id');
    }
}
