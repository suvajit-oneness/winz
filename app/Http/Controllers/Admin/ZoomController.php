<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;use App\Models\User;
use App\Models\ZoomMeeting;use App\Models\Teacher;

class ZoomController extends Controller
{
    public function index(Request $req)
    {
    	$zoom = ZoomMeeting::select('*');
    	if(!empty($req->teacherId)){
    		$zoom = $zoom->where('teacherId',$req->teacherId);
    	}
        $zoom = $zoom->latest()->get();
        $teacherList = Teacher::select('*')->get();
    	return view('admin.zoom.index',compact('zoom','teacherList','req'));
    }

    public function createMeeting(Request $req)
    {
    	$teachers = Teacher::select('*')->latest()->get();
    	$users = User::select('*')->where('userType','user')->where('is_active',1)->get();
    	return view('admin.zoom.create',compact('teachers','users'));
    }

    public function saveMeeting(Request $req)
	{
		$req->validate([
			'topic' => 'required|string|max:200',
			'startime' => 'required',
			'teacher' => 'required|min:1|numeric',
			'user' => 'required|min:1|numeric',
			'agenda' => 'string|nullable',
		]);
		$teacher = Teacher::where('id',$req->teacher)->first();
		if($teacher){
			$student = User::where('id',$req->user)->where('userType','user')->where('is_active',1)->first();
			if($student){
				$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
				$response = $client->request('POST', '/v2/users/me/meetings', [
			        "headers" => [
			            "Authorization" => "Bearer " . $this->generateToken(),
			        ],
			        'json' => [
			            "topic" => $req->topic,
			            "type" => 2,
			            "start_time" => $req->startime,
			            "duration" => "30", // 30 mins
			            "password" => "123456",
			            "agenda" => $req->agenda,
			        ],
			    ]);
			    $data = json_decode($response->getBody());
			    if($data){
			    	$newMeeting = new ZoomMeeting;
			    	$newMeeting->teacherId = $teacher->id;
			    	$newMeeting->userId = $student->id;
			    	$newMeeting->userType = 'user';
			    	$newMeeting->uuid = $data->uuid;
			    	$newMeeting->meetingId = $data->id;
			    	$newMeeting->host_id = $data->host_id;
			    	$newMeeting->host_email = $data->host_email;
			    	$newMeeting->topic = $data->topic;
			    	$newMeeting->start_time = $data->start_time;
			    	$newMeeting->agenda = !empty($data->agenda) ? $data->agenda : '';
			    	$newMeeting->join_url = $data->join_url;
			    	$newMeeting->password = !empty($data->password) ? $data->password : '';
			    	$newMeeting->encrypted_password = !empty($data->encrypted_password) ? $data->encrypted_password : '';
			    	$newMeeting->status = $data->status;
			    	$newMeeting->type = $data->type;
			    	$newMeeting->start_url = !empty($data->start_url) ? $data->start_url : '';
			    	$newMeeting->created_by = 'admin';
			    	$newMeeting->save();
			    	return redirect(route('admin.zoom.index'))->with('status','Zoom Meeting Created Success');
			    }
			}
		}
		return back()->with('status','Something went wrong please try after some time')->withInput($req->all());
		
	}

	public function deleteZoomMeeting(Request $req)
	{
		$rules = [
			'zoomMeetingId' => 'required|min:1|numeric',
    		'meetingId' => 'required',
    	];
    	$validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
        	$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
			$response = $client->request("DELETE", "/v2/meetings/$req->meetingId", [
		        "headers" => [
		            "Authorization" => "Bearer " . $this->generateToken(),
		        ]
		    ]);
		    if (204 == $response->getStatusCode()) {
		    	ZoomMeeting::where('id',$req->zoomMeetingId)->where('meetingId',$req->meetingId)->delete();
		    	return sendResponse('Meeting Deleted Success',$response);
	    	}
        }
        return errorResponse($validator->errors()->first());
	}
}
