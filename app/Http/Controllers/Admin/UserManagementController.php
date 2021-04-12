<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserContract;
use App\Http\Controllers\BaseController;
use App\Models\Membership;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;use Datatables;

class UserManagementController extends BaseController
{

    protected $UserRepository;

    /**
     * UserManagementController constructor.
     * @param UserRepository $UserRepository
     */

    public function __construct(UserContract $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * List all the users
     */
    public function index(Request $req)
    {
        if($req->ajax()){
            $users = User::select('*')->where('userType','user')->with('membership');
            return Datatables::of($users)->make();
        }
    	$this->setPageTitle('Users', 'List of all users');
    	return view('admin.users.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $membership = Membership::where('is_active',1)->get();

        $this->setPageTitle('User', 'Create User');
        return view('admin.users.create',compact('membership'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     =>  'required|max:191',
            'email'     =>  'required|max:191|email|unique:users',
            'mobile'     =>  'required|unique:users',
            'password'     =>  'required|max:16|min:5',
        ]);

        $params = $request->except('_token');
        
        $user = $this->UserRepository->createUser($params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while creating user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'user added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetUser = $this->UserRepository->findUserById($id);

        $membership = Membership::where('is_active',1)->get();
        
        $this->setPageTitle('User', 'Edit User : '.$targetUser->name);
        return view('admin.users.edit', compact('targetUser','membership'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'     =>  'required|max:191',
            'email'     =>  'required|max:191|email',
            'mobile'     =>  'required',
        ]);

        $params = $request->except('_token');

        $user = $this->UserRepository->updateUser($params);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while updating user.', 'error', true, true);
        }
        return $this->responseRedirectBack('User updated successfully' ,'success',false, false);
    }

    /**
     * Update user with approve or block status
     * @param Request $request 
     */
    public function updateUser(Request $request)
    {
        $response = $this->UserRepository->blockUser($request->user_id,$request->is_block);

        if($response){
            return response()->json(array('message'=>'Successfully updated'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $user = $this->UserRepository->updateUserStatus($params);

        if ($user) {
            return response()->json(array('message'=>'User status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = $this->UserRepository->deleteUser($id);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while deleting user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'User deleted successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function viewDetail($id)
    {
        $userdetails = User::findOrFail($id);
        if (!$userdetails) {
            return $this->responseRedirectBack('user not found.', 'error', true, true);
        }
        $this->setPageTitle('User', 'User Details : '.$userdetails->name);
        return view('admin.users.details', compact('userdetails'));
    }
}
