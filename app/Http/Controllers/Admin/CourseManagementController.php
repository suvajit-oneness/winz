<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;use App\Models\Course;
use App\Models\CourseLecture;use App\Models\CourseFeature;

class CourseManagementController extends BaseController
{
	// Course Details
    public function index(Request $req)
    {
    	$course = Course::with('lecture')->with('feature')->withTrashed()->get();
    	return view('admin.course.index',compact('course'));
    }

    public function createCourse(Request $req)
    {
    	return view('admin.course.create');
    }

    public function saveCourse(Request $req)
    {
    	$req->validate([
    		'image' => 'required',
    		'name' => 'required|max:200|string|unique:courses,course_name',
    		'price' => 'required|numeric|min:1|max:99999',
    		'description' => 'required',
    	]);
    	$course = new Course;
    	if($req->hasFile('image')){
            $image = $req->file('image');
            $random = date('Ymdhis').rand(0000,9999);
            $image->move('upload/course/',$random.'.'.$image->getClientOriginalExtension());
            $imageurl = url('upload/course/'.$random.'.'.$image->getClientOriginalExtension());
            $course->course_image = $imageurl;
        }
    	$course->course_name = $req->name;
    	$course->course_price = $req->price;
    	$course->course_description = $req->description;
    	$course->save();
    	return $this->responseRedirect('admin.course', 'Course added successfully' ,'success',false, false);
    }

    public function deleteCourse(Request $req)
    {
    	$rules = [
    		'id' => 'required|min:1|numeric',
    		'status' => 'required|in:1,2',
    	];
    	$validate = validator()->make($req->all(),$rules);
    	if(!$validate->fails()){
    		$deleted_at = date('Y-m-d h:i:s');
    		if($req->status == 1){
    			$deleted_at = null;
    		}
    		Course::where('id',$req->id)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    		return response()->json(['error'=>false,'message'=>'Course Status Updated successfully']);
    	}
    	return response()->json(['error'=>true,'message'=>$validate->errors()->first()]);
    }

    public function editCourse(Request $req,$courseId)
    {
    	$course = Course::where('id',$courseId)->withTrashed()->first();
    	return view('admin.course.edit',compact('course'));
    }

    public function updateCourse(Request $req, $id)
    {
    	$req->validate([
    		'name' => 'required|max:200|string',
    		'price' => 'required|numeric|min:1|max:99999',
    		'description' => 'required',
    	]);
    	$check = Course::where('id','!=',$id)->where('course_name',$req->name)->withTrashed()->first();
    	if(!$check){
    		$course = Course::where('id',$id)->withTrashed()->first();
	    	if($req->hasFile('image')){
	            $image = $req->file('image');
	            $random = date('Ymdhis').rand(0000,9999);
	            $image->move('upload/course/',$random.'.'.$image->getClientOriginalExtension());
	            $imageurl = url('upload/course/'.$random.'.'.$image->getClientOriginalExtension());
	            $course->course_image = $imageurl;
	        }
	    	$course->course_name = $req->name;
	    	$course->course_price = $req->price;
	    	$course->course_description = $req->description;
	    	$course->save();
	    	return $this->responseRedirect('admin.course', 'Course Updated successfully' ,'success',false, false);
    	}
    	$error['name'] = 'The name has already been taken.';
    	return back()->withErrors($error)->withInput($req->all());
    }

    // Course Lecture Details
    public function lectures(Request $req,$courseId)
    {
    	$course = Course::where('id',$courseId)->with('lecture')->withTrashed()->first();
    	return view('admin.course.lecture.index',compact('course'));
    }

    public function deleteLectures(Request $req)
    {
    	$rules = [
    		'id' => 'required|min:1|numeric',
    		'courseId' => 'required|min:1|numeric',
    		'status' => 'required|in:1,2',
    	];
    	$validate = validator()->make($req->all(),$rules);
    	if(!$validate->fails()){
    		$deleted_at = date('Y-m-d h:i:s');
    		if($req->status == 1){
    			$deleted_at = null;
    		}
    		CourseLecture::where('id',$req->id)->where('course_id',$req->courseId)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    		return response()->json(['error'=>false,'message'=>'Lecture Status Updated successfully']);
    	}
    	return response()->json(['error'=>true,'message'=>$validate->errors()->first()]);
    }

    // Course Features Details
    public function features(Request $req, $courseId)
    {
    	$course = Course::where('id',$courseId)->with('feature')->withTrashed()->first();
    	return view('admin.course.feature.index',compact('course'));
    }

    public function deleteFeatures(Request $req)
    {
    	$rules = [
    		'id' => 'required|min:1|numeric',
    		'courseId' => 'required|min:1|numeric',
    		'status' => 'required|in:1,2',
    	];
    	$validate = validator()->make($req->all(),$rules);
    	if(!$validate->fails()){
    		$deleted_at = date('Y-m-d h:i:s');
    		if($req->status == 1){
    			$deleted_at = null;
    		}
    		CourseFeature::where('id',$req->id)->where('course_id',$req->courseId)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    		return response()->json(['error'=>false,'message'=>'Feature Status Updated successfully']);
    	}
    	return response()->json(['error'=>true,'message'=>$validate->errors()->first()]);
    }

}
