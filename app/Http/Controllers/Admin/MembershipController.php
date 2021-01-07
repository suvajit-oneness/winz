<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\MembershipContract;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;use App\Models\Membership;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;use Datatables;

class MembershipController extends BaseController
{
    /**
     * @var MembershipContract
     */
    protected $membershipRepository;

    /**
     * BoardController constructor.
     * 
     * @param MembershipContract $membershipRepository
     */
    public function __construct(MembershipContract $membershipRepository)
    {
        $this->membershipRepository = $membershipRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        // $membership = $this->membershipRepository->listMemberships();
        if($req->ajax()){
            $membership = Membership::select('*');
            return Datatables::of($membership)->make();
        }
        $this->setPageTitle('Membership', 'List of all Memberships');
        return view('admin.membership.index');
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create(){

        $this->setPageTitle('Membership', 'Create Membership');
        return view('admin.membership.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request){

        $this->validate($request, [
            'title'     =>  'required',
            'price'     =>  'required'
        ]);

        $params = $request->except('_token');

        $status = $this->membershipRepository->createMembership($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Membership.', 'error', true, true);
        }
        return $this->responseRedirect('admin.membership.index', 'Membership added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit($id){

        $targetmembership = $this->membershipRepository->findMembershipById($id);
        
        $this->setPageTitle('Membership', 'Edit Membership : '.$targetmembership->title);
        return view('admin.membership.edit', compact('targetmembership'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function update(Request $request){

        $this->validate($request, [
            'title'     =>  'required',
            'price'     =>  'required'
        ]);

        $params = $request->except('_token');

        $status = $this->membershipRepository->updateMembership($params);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Membership.', 'error', true, true);
        }
        return $this->responseRedirectBack('Membership updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete($id){

        $response = $this->membershipRepository->deleteMembership($id);

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Membership.', 'error', true, true);
        }
        return $this->responseRedirect('admin.membership.index', 'Membership deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $status = $this->membershipRepository->updateStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Membership status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function viewDetail($packageId){
        
        $targetmembership = $this->membershipRepository->findMembershipById($packageId);

        if (!$targetmembership) {
            return $this->responseRedirectBack('Membership not found.', 'error', true, true);
        }
        
        $this->setPageTitle('Membership', 'Membership Details: '.$targetmembership->title);
        return view('admin.membership.details', compact('targetmembership'));
    }
}
