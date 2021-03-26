<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherBooking extends Model
{
    public function userInfo()
    {
    	return $this->belongsTo('App\Models\User','userId','id');
    }

    public function slotInfo()
    {
    	return $this->belongsTo('App\Models\Schedule','scheduleId','id');
    }

    public function teacherInfo()
    {
    	return $this->belongsTo('App\Models\Teacher','teacherId','id');
    }
}
