<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use Auth;use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;use URL;use Validator;
use App\Models\Course;use App\Models\Teacher;
use App\Models\HomeContent;use App\Models\CourseLecture;use App\Models\CourseFeature;
use App\Models\User;

class Apicontroller extends Controller
{

    public function updateProfile(Request $req)
    {
        $rules = [
          'userId' => 'required|min:1|numeric',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
          $user = User::where('id',$req->userId)->first();
          if($user){
            $user->name = ($req->name) ? $req->name : '';
            $user->address = ($req->address) ? $req->address : '';
            $user->mobile = ($req->mobile) ? $req->mobile : '';
            $user->save();
            return sendResponse('Profile Updated Success',$user);
          }
          return errorResponse('Invalid User Id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function changeUserPassword(Request $req)
    {
        if(!empty($req->userId)){
          if(!empty($req->password) && !empty($req->confirmpassword)){
            if($req->password == $req->confirmpassword){
              $user = User::where('id',$req->userId)->first();
              if($user){
                $user->password = Hash::make($req->password);
                $user->save();
                return sendResponse('Password Updated Success');
              }
              return errorResponse('Invalid User id');
            }
            return errorResponse('password and confirm password should be same');
          }
          return errorResponse('password and confirm password is required');
        }
        return errorResponse('userId is required');
    }


    public function getHomeContent(Request $req)
    {
        $HomeContent = HomeContent::get();
        $data = [];
        foreach ($HomeContent as $content) {
            $data[$content->key][] = $content;
        }
        return sendResponse('Home Content',$data);
    }

    public function get_teacher(Request $req,$teacherId = 0)
    {
        if($teacherId == 0){
          $teacher = Teacher::get();
        }else{
            $teacher = Teacher::where('id',$teacherId)->first();
            $teacher->teacherCourses = Course::get();
        }
        return sendResponse('Teacher List',$teacher);
    }

    public function get_course(Request $req,$courseId = 0)
    {
      if($courseId == 0){
        $course = Course::get();
      }else{
          $course = Course::where('id',$courseId)->first();
          $course->similarCourses = Course::where('id','!=',$courseId)->get();
          $course->features = CourseFeature::where('course_id',$courseId)->get();
          $course->lectures = CourseLecture::where('course_id',$courseId)->get();
      }
      return sendResponse('Course List',$course);
    }

  	public $successStatus = 200;
    public $errorStatus = 401;

  	public function city($stateid)
  	{
        $city = City::where('is_active',1)->where('state_id',$stateid)->get();
        return response()
            ->json(['message'=>'success','status'=>'1',"city"=>$city], $this->successStatus);
  	}

    public function checkcoupon($couponcode){

        $code = $couponcode;

        $use_date = date("Y-m-d");

        $result = DB::select("select * from coupon_codes where coupon_code='$code'
            and (start_date<='$use_date' and end_date>='$use_date')");
       
        if (count($result) > 0) {

            $offer_type = $result[0]->offer_type;
            $offer_rate = $result[0]->offer_rate;

            return response()
          ->json(['message'=>'success','status'=>'1','offer_type'=>$offer_type,'offer_rate'=>$offer_rate], $this->successStatus);
           
        } else {
            return response()
          ->json(['message'=>'error','status'=>'0'], $this->successStatus);
        }
    }
}
