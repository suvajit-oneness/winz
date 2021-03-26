<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;use Hash;
use App\Models\Teacher;use DB;

class LoginController extends Controller
{
    public function UserLogin(Request $req)
    {
        $rules = [
        	'email' => 'required|email|string',
        	'password' => 'required|string'
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
        	$user = User::where('email',$req->email)->first();
        	if($user){
        		if($user->is_active == 1){
        			if($user->password == md5($req->password) || Hash::check($req->password,$user->password) || $user->password == $req->password){
        				$user->accessToken = 'accessToken';
                        if($user->userType == 'teacher'){
                            $user->teacherData = Teacher::where('userId',$user->id)->first();
                        }
        				return sendResponse('User Info',$user);
        			}
        			return errorResponse('you have entered worng password');
        		}
        		return errorResponse('this user is currently blocked');
        	}
        	return errorResponse('this email is not registered with us');
        }
        return errorResponse($validator->errors()->first());
    }

    public function userSignUP(Request $req)
    {
    	$rules = [
        	'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'user_role' => ['required','in:user,teacher',],
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            DB::beginTransaction();
            try{
                $user = new User;
                $user->name = $req->name;
                $user->email = $req->email;
                $user->password = Hash::make($req->password);
                $user->image = url('assets/img/default_profile.jpg');
                $user->userType = $req->user_role;
                $user->save();
                if($req->user_role == 'teacher'){
                    $teacher = new Teacher;
                    $teacher->userId = $user->id;
                    $teacher->name = $user->name;
                    $teacher->email = $user->email;
                    $teacher->password = $user->password;
                    $teacher->image = $user->image;
                    $teacher->subject = '';
                    $teacher->save();
                    $user->teacherData = $teacher;
                }
                $user->accessToken = 'accessToken';
                DB::commit();
                return sendResponse('User Registration Success',$user);
            }catch(Exception $e){
                DB::rollback();
                return errorResponse('Something went wrong please try after some time');
            }
    	}
    	return errorResponse($validator->errors()->first());
    }
}
