<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;use Datatables;
use App\Models\Membership;
use DB;use Hash;use App\Models\Teacher;

class TeacherManagementController extends Controller
{
    public function index(Request $req)
    {
    	if($req->ajax()){
            $users = User::select('*')->where('userType','teacher')->orderBy('id','desc');
            return Datatables::of($users)->make();
        }
    	return view('admin.teacher.index');
    }

    public function create(Request $req)
    {
    	// $membership = Membership::where('is_active',1)->get();
        return view('admin.teacher.create');
    }

    public function saveTeacher(Request $req)
    {
    	$req->validate([
    		'name' => 'required|max:200',
    		'email' => 'required|email|max:200|unique:users',
    		'mobile' => 'required|numeric',
    		'password' => 'required',
    		'gender' => 'required|in:1,2',
    		'price' => 'required',
    	]);
    	DB::beginTransaction();
    	try {
    		$user = new User;
    		$user->name = $req->name;
    		$user->email = $req->email;
    		$user->mobile = $req->mobile;
    		$user->password = Hash::make($req->password);
    		$user->userType = 'teacher';
    		$user->gender = $req->gender;
    		$user->is_active = 1;
    		$user->save();
    		$teacher = new Teacher;
    		$teacher->userId = $user->id;
    		$teacher->name = $user->name;
    		$teacher->email = $user->email;
    		$teacher->password = $user->password;
    		$teacher->gender = ($user->gender == 1) ? 'Male' : 'Female';
    		$teacher->price_per_hour = $req->price;
    		$teacher->save();
    		DB::commit();
    		return redirect(route('admin.teacher.index'))->with('Success','Teacher Added Successfully');
    	} catch (Exception $e) {
    		DB::rollback();
    	}
    	$error['price'] = 'Something went wrong please try after some time';
    	return back()->withError($error)->withInput($req->all());
    }

    public function editTeacher(Request $req, $id)
    {
    	$user = User::where('id',$id)->where('userType','teacher')->with('teacher')->first();
    	return view('admin.teacher.edit',compact('user'));
    }

    public function updateTeacher(Request $req,$id)
    {
    	$req->validate([
    		'name' => 'required|max:200',
    		'email' => 'required|email|max:200|unique:users,email,'.$id,
    		'mobile' => 'required|numeric',
    		'gender' => 'required|in:1,2',
    		'price' => 'required',
    	]);
    	DB::beginTransaction();
    	try {
    		$user = User::where('id',$id)->where('userType','teacher')->first();
    		$user->name = $req->name;
    		$user->email = $req->email;
    		$user->mobile = $req->mobile;
    		$user->gender = $req->gender;
    		$user->save();
    		$teacher = Teacher::where('userId',$user->id)->first();
    		$teacher->name = $user->name;
    		$teacher->email = $user->email;
    		$teacher->gender = ($user->gender == 1) ? 'Male' : 'Female';
    		$teacher->price_per_hour = $req->price;
    		$teacher->save();
    		DB::commit();
    		return redirect(route('admin.teacher.index'))->with('Success','Teacher Updated Successfully');
    	} catch (Exception $e) {
    		DB::rollback();
    	}
    	$error['price'] = 'Something went wrong please try after some time';
    	return back()->withError($error)->withInput($req->all());
    }
}
