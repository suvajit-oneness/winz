<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\ChapterPurchase;
use App\Models\BuyMemberShip;

class BookingController extends BaseController
{
    public function allBookings(Request $req)
    {
        $bookings = ChapterPurchase::with('userDetail', 'course', 'chapter', 'transaction')->orderBy('id', 'DESC')->paginate(10);
        // dd($bookings);
        if($req->ajax()) {
            dd('hi 1');
        }
        $this->setPageTitle('All Bookings', 'List of all bookings');
        return view('admin.bookings.all', compact('bookings'));
    }
    
    public function membershipBookings(Request $req)
    {
        $bookings = BuyMemberShip::with('transactionDetails', 'membership', 'userDetail')->orderBy('id', 'DESC')->paginate(10);
        // dd($bookings);
        if($req->ajax()) {
            dd('hi 2');
        }
        $this->setPageTitle('Membership Bookings', 'List of membership bookings');
        return view('admin.bookings.membership', compact('bookings'));
    }
}
