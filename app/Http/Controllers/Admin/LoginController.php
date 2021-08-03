<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Course;
use App\Models\ChapterPurchase;
use App\Models\BuyMemberShip;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect admins after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout','index']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember_me)) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    public function index(){
        $data = (object)[];
        $data->userCount = User::where('userType', 'user')->get()->count();
        $data->teacherCount = User::where('userType', 'teacher')->get()->count();
        $data->courseCount = Course::get()->count();
        $bookingData = ChapterPurchase::select('*');
        $data->bookingCount = $bookingData->get()->count();
        $data->latestBookingCount = $bookingData->where('created_at' , '>=', date('Y-m-d', strtotime("-1 month")))->get()->count();
        $data->lastTenBookings = $bookingData->with('userDetail', 'course', 'chapter', 'transaction')->orderBy('id', 'DESC')->limit(10)->get();
        $memberShipBookingData = BuyMemberShip::select('*');
        $data->memberShipBookingCount = $memberShipBookingData->get()->count();
        $data->lastTenMemberShipBookings = $memberShipBookingData->with('transactionDetails', 'membership', 'userDetail')->orderBy('id', 'DESC')->limit(10)->get();
        // dd($data);
        return view('admin.dashboard.index',compact('data'));
    }
}