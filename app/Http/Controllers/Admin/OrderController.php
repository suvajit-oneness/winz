<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\OrderDispatched;
use App\Models\Booking;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;use Datatables;

class OrderController extends BaseController
{
	/**
        * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */

    public function index(Request $req)
    {
        $order = Booking::orderBy('id','desc')->where('payment_mode',3)->orWhere('transaction_id','!=','')->get();
        if($req->ajax()){
            $order = Booking::select('*')->where('payment_mode',3)->orWhere('transaction_id','!=','');
            return Datatables::of($order)->make();
        }
        $couriers = Courier::where('is_active',1)->get();
        // $order = [];
        $this->setPageTitle('Order', 'List of all Order');
        return view('admin.order.index', compact('order','couriers'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete($id){

        $response = Booking::find($id)->delete();

        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting Order.', 'error', true, true);
        }
        return $this->responseRedirect('admin.orders.index', 'Order deleted successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function viewDetail($id)
    {
        $booking = Booking::findOrFail($id);

        $bookingProducts = DB::table('booking_products')->where('booking_id',$id)->get();

        $this->setPageTitle('Booking', 'Booking Detail: ');

        return view('admin.order.details', compact('booking','bookingProducts'));
    }

    /**
     * @param Request $request
     * @param $id ProductId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function updatecourier(Request $request, $id){

        $booking = Booking::findOrFail($id);

        $booking->courier_name = $request->courier_name;
        $booking->pod_no = $request->pod_no;
        $booking->status = 2;
        $status = $booking->save();

        if (!$status) {
            return $this->responseRedirectBack('Error occurred while updating Courier.', 'error', true, true);
        }

        //Mail::to('satyapriyakundu.ots@gmail.com')->send(new OrderDispatched($booking));

        return $this->responseRedirectBack('Courier updated successfully' ,'success',false, false);
    }

    public function invoice($orderId, Request $request){
       
        $booking = Booking::findOrFail($orderId);

        //view()->share('booking',$booking);

        if($request->has('download')){
            $pdf = PDF::loadView('admin.order.invoice');
            return $pdf->download('admin.order.invoice');
        }
        
        $this->setPageTitle('invoice', 'Booking Detail: ');
        return view('admin.order.invoice',compact('booking'));
    }

    public function makepdf($orderId, Request $request){

        $booking = Booking::findOrFail($orderId);
        
        /*$pdf = PDF::loadView('admin.order.invoice',[
            'booking'=> $booking,
        ]);*/

        /*if($request->has('download')){
            $pdf = PDF::loadView('admin.order.invoice');
            return $pdf->download('admin.order.invoice');
        }*/

        return view('admin.order.invoice');
    }
}
