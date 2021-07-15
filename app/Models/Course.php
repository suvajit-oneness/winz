<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    USE SoftDeletes;

    function teacher()
    {
    	return $this->belongsTo('App\Models\Teacher','teacherId','id');
    }

    function feature()
    {
    	return $this->hasMany('App\Models\CourseFeature','course_id','id');
    }

    function chapter(){
        return $this->hasMany('App\Models\Chapter','courseId','id');
    }

    public function overallcourseprice($courseId)
    {
        $chapterprice = \App\Models\Chapter::where('courseId',$courseId)->sum('price');
        return '$ '.number_format($chapterprice,2);
    }

    public function overallchapter()
    {
        return $this->hasMany('App\Models\Chapter','courseId','id');

        /*$chaptercount = \App\Model\Chapter::where('courseId',$courseId)->get();
        return $chaptercount;*/
    }
}
