<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class ShippingChargeController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(){

        $shippingCharge =  ShippingCharge::orderBy('id','desc')->get();

        $this->setPageTitle('Shipping Charge', 'List of all shipping charges');
        return view('admin.shippingcharge.index', compact('shippingCharge'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create(){

        $category = Category::where('is_active',1)->get();

        $this->setPageTitle('shipping Charge', 'Create shipping Charge');
        return view('admin.shippingcharge.create',compact('category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request){

        $this->validate($request, [
            'categoryId'     =>  'required',
            'shippingcharge'     =>  'required'
        ]);

        $brands =  $request->all();
        $brands['is_active'] = 1;

        $brand = ShippingCharge::create($brands);

        if (!$brand) {
            return $this->responseRedirectBack('Error occurred while creating shipping Charge.', 'error', true, true);
        }
        return $this->responseRedirect('admin.shippingcharge.index', 'shipping Charge added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit($id){

        $targetshippingCharge = ShippingCharge::findOrFail($id);

        $category = Category::where('is_active',1)->get();
        
        $this->setPageTitle('Shipping Charge', 'Edit shipping Charge : '.$targetshippingCharge->shippingcharge);
        return view('admin.shippingcharge.edit', compact('targetshippingCharge','category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function update(Request $request){

        $this->validate($request, [
            'categoryId'     =>  'required',
            'shippingcharge'     =>  'required'
        ]);

            $id = $request->id;
            $data = $request->all();

            $targetshippingCharge = ShippingCharge::findOrFail($id);

        $status = $targetshippingCharge->update($data);

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating shipping charge.', 'error', true, true);
        }
        return $this->responseRedirectBack('Shipping Charge updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete($id){

        $response = ShippingCharge::find($id)->delete();

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting shipping charge.', 'error', true, true);
        }
        return $this->responseRedirect('admin.shippingcharge.index', 'Shipping charge deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function updateStatus(Request $request){

        $id = $request->id;
        $ShippingCharge =  ShippingCharge::findOrFail($id);

        $ShippingCharge->is_active = $request->is_active;

        $status = $ShippingCharge->save();

        if ($status) {
            return response()->json(array('message'=>'Shipping charge status successfully updated'));
        }
    }
}
