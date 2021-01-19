<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;

    function subjectCategory()
    {
    	return $this->belongsTo('App\Models\SubjectCategory','subjectCategoryId','id');
    }

    function category()
    {
    	return $this->belongsTo('App\Models\Category','subjectCategoryId','id');
    }

    // return $this->hasMany('App\Models\TeacherCourse','course_id','id')
    		// ->leftjoin('teachers','teacher_courses.teacher_id','teachers.id');
}
