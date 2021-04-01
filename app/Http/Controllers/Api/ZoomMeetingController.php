<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZoomMeeting;

class ZoomMeetingController extends Controller
{
    public function getMeetings(Request $req)
    {
    	$rules = [
    		'userId' => 'required|min:1|numeric',
    		'userType' => 'required|in:user,teacher|string',
    	];
    	$validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
        	$zoom = ZoomMeeting::where('userId',$req->userId)->where('userType',$req->userType)->get();
    		return sendResponse('Zoom Meeting Data',$zoom);
        }
        return errorResponse($validator->errors()->first());
    }

    public function createMeeting(Request $req)
	{
		$rules = [
			'userId' => 'required|min:1|numeric',
    		'userType' => 'required|in:user,teacher|string',
    		'topic' => 'required|string',
			'start_time' => 'required|date',
			'agenda' => 'string|nullable',
    	];
    	$validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
        	$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
			$response = $client->request('POST', '/v2/users/me/meetings', [
		        "headers" => [
		            "Authorization" => "Bearer " . $this->generateToken(),
		        ],
		        'json' => [
		            "topic" => $req->topic,
		            "type" => 2,
		            "start_time" => $req->start_time,
		            "duration" => "30", // 30 mins
		            "password" => "123456",
		            "agenda" => $req->agenda,
		        ],
		    ]);
		    $data = json_decode($response->getBody());
		    if($data){
		    	$newMeeting = new ZoomMeeting;
		    	$newMeeting->userId = $req->userId;
		    	$newMeeting->userType = $req->userType;
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
		    	$newMeeting->save();
		    }
		    return sendResponse('Zoom Meeting Created Success',$newMeeting);
        }
        return errorResponse($validator->errors()->first());
	}

	public function deleteZoomMeeting(Request $req)
	{
		$rules = [
			'zoomMeetingId' => 'required|min:1|numeric',
			'userId' => 'required|min:1|numeric',
    		'userType' => 'required|in:user,teacher|string',
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
		    	ZoomMeeting::where('id',$req->zoomMeetingId)->where('userId',$req->userId)->where('userType',$req->userType)->where('meetingId',$req->meetingId)->delete();
		    	return sendResponse('Meeting Deleted Success',$response);
	    	}
        }
        return errorResponse($validator->errors()->first());
	}

	public function generateToken()
	{
		$key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];
        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
	}
}
