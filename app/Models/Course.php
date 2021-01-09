<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    USE SoftDeletes;

    function teacher()
    {
    	return $this->hasMany('App\Models\TeacherCourse','course_id','id')
    		->leftjoin('teachers','teacher_courses.teacher_id','teachers.id');
    }
}
