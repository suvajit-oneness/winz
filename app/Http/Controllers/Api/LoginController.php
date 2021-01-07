<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;use Hash;

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
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
    		$user = new User;
    		$user->name = $req->name;
    		$user->email = $req->email;
    		$user->password = Hash::make($req->password);
    		$user->save();
    		$user->accessToken = 'accessToken';
    		return sendResponse('User Registration Success',$user);
    	}
    	return errorResponse($validator->errors()->first());
    }
}
