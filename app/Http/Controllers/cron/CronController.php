<?php

namespace App\Http\Controllers\cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class CronController extends Controller
{
    public function createTeacherSchedule(Request $req)
    {
    	// $teacher = Teacher::select('*');
    	// if(!empty($req->teacherId)){
    	// 	$teacher = $teacher->where('id',$req->teacherId);
    	// }
    	// $teacher = $teacher->get();
    	// $originalDate = date('Y-m-d');
    	
    	// foreach($teacher as $key => $createSchedule){
    	// 	$originalDate = date('Y-m-d');
    	// 	for($loop = 0; $loop < 7; $loop++){
    	// 		$date = date('Y-m-d',strtotime($originalDate.'+'.$loop.' days'));
    	// 	}
    	// }
    }
}
