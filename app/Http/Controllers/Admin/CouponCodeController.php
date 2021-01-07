<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use DataTables;

class CouponCodeController extends BaseController
{
	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        if($req->ajax()){
            $couponcode = CouponCode::where('id','!=',0);
            return Datatables::of($couponcode)->make();
        }
        $this->setPageTitle('Couponcode', 'List of all Couponcode');
        return view('admin.couponcode.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Couponcode', 'Create Couponcode');
        return view('admin.couponcode.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'coupon_name'     =>  'required|max:191',
            'coupon_code'=>  'required',
            'start_date'=>  'required',
            'end_date'=>  'required',
            'offer_type'=>  'required',
            'offer_rate'=>  'required',
            'maximum_time_of_use'=>  'required',
            'maximum_user_can_use'=>  'required',
        ]);
        $couponcode =  $request->all();
        $status = CouponCode::create($couponcode);
        if (!$status) {
            return $this->responseRedirectBack('Error occurred while creating Couponcode.', 'error', true, true);
        }
        return $this->responseRedirect('admin.couponcode.index', 'Couponcode added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $couponCode = CouponCode::findOrFail($id);
        
        $this->setPageTitle('Couponcode', 'Edit Couponcode : '.$couponCode->coupon_code);
        return view('admin.couponcode.edit', compact('couponCode'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'coupon_name'     =>  'required|max:191',
            'coupon_code'=>  'required',
            'start_date'=>  'required',
            'end_date'=>  'required',
            'offer_type'=>  'required',
            'offer_rate'=>  'required',
            'maximum_time_of_use'=>  'required',
            'maximum_user_can_use'=>  'required',
        ]);

        $id = $request->id;
        $data = $request->all();

        $targetcouponcode= CouponCode::findOrFail($id);

        $status = $targetcouponcode->update($data);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Couponcode.', 'error', true, true);
        }
        return $this->responseRedirectBack('Couponcode updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $response = CouponCode::find($id)->delete();

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Couponcode.', 'error', true, true);
        }
        return $this->responseRedirect('admin.couponcode.index', 'Couponcode deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $id = $request->id;
        $Couponcode =  CouponCode::findOrFail($id);

        $Couponcode->is_active = $request->is_active;
        $status = $Couponcode->save();

        if ($status) {
            return response()->json(array('message'=>'Couponcode status successfully updated'));
        }
    }
}
