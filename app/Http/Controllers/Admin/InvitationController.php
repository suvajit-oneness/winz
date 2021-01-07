<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Mail;
use App\Mail\SendEmail;

class InvitationController extends BaseController
{
    /**
     * Display a listing of the invited users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get();;

        $this->setPageTitle('Pending Request', 'List of all invitation');
        return view('admin.invite.index', compact('invitations'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Invite Admin', '');
        return view('admin.invite.create');
    }

    /**
     * Store a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email'      =>  'required|email|unique:invitations',
        ]);

        $invitation = new Invitation($request->all());
        $invitation->generateInvitationToken();
        $invitation->save();
        
        //Send invitation email to the user
        $link = $invitation->getLink();
        $toEmail = $request->email;
    	Mail::to($toEmail)->send(new SendEmail($link));

        if (!$invitation) {
            return $this->responseRedirectBack('Error occurred while invite admin.', 'error', true, true);
        }
        return $this->responseRedirect('admin.adminuser', 'Invitation link has been sent to the user' ,'success',false, false);
    }
}
