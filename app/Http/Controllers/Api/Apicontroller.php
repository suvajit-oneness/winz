<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;use App\Models\Schedule;
use App\Models\City;use Auth;use Hash;use App\Models\Chapter;
use Illuminate\Http\Request;use App\Models\SubjectCategory;
use App\Models\Category;use App\Models\Contact;use Session;
use Illuminate\Support\Facades\DB;use App\Models\Question;
use URL;use Validator;use App\Models\CommonQuestion;
use App\Models\Course;use App\Models\Teacher;use App\Models\Membership;
use App\Models\HomeContent;use App\Models\CourseLecture;use App\Models\CourseFeature;
use App\Models\User;use App\Models\SubscribedCourses;use App\Models\TeacherCourse;
use Stripe;use App\Models\StripeTransaction;use App\Models\TeacherBooking;

// header('Access-Control-Allow-Origin: *');
// header('Content-Type:application/json');

class Apicontroller extends Controller
{
    public function updateProfile(Request $req)
    {
        $rules = [
          'userId' => 'required|min:1|numeric',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            DB::beginTransaction();
            try{
                $user = User::where('id',$req->userId)->first();
                if($user){
                    $user->name = ($req->name) ? $req->name : '';
                    $user->address = ($req->address) ? $req->address : '';
                    $user->mobile = ($req->mobile) ? $req->mobile : '';
                    if($req->hasFile('userImage')){
                        $image = $req->file('userImage');
                        $random = date('Ymdhis').rand(0000,9999);
                        $image->move('upload/profile/',$random.'.'.$image->getClientOriginalExtension());
                        $imageurl = url('upload/profile/'.$random.'.'.$image->getClientOriginalExtension());
                        $user->image = $imageurl;
                    }
                    $user->save();
                    if($user->userType == 'teacher'){
                        $teacher = Teacher::where('userId',$user->id)->first();
                        $teacher->name = $user->name;
                        $teacher->email = $user->email;
                        $teacher->image = $user->image;
                        $teacher->subject = ($req->subject) ? $req->subject : '';
                        $teacher->save();
                        $user->teacherData = $teacher;
                    }
                    $user->accessToken = 'accessToken';
                    DB::commit();
                    return sendResponse('Profile Updated Success',$user);
                }
                return errorResponse('Invalid User Id');
            }catch(Exception $e){
                DB::rollback();
                return errorResponse('Something went wrong please try after some time');
            }
        }
        return errorResponse($validator->errors()->first());
    }

    public function getScheduledData(Request $req)
    {
        $rules = [
          'teacherId' => 'required|min:1|numeric',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $schedule = Schedule::where('teacherId',$req->teacherId)->get();
            return sendResponse('Teacher Scheduled Data',$schedule);
        }
        return errorResponse($validator->errors()->first());
    }

    public function getTeacherSlots(Request $req)
    {
        $rules = [
          'teacherId' => 'required|min:1|numeric',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $date = date('Y-m-d');
            if(!empty($req->date)){
                $date = date('Y-m-d',strtotime($req->date));
            }
            $originalDate = date('Y-m-d',strtotime($date));$originalDay = date('D',strtotime($date));
            $daysData = [];
            for($i = 0; $i < 7;$i++){
                $date = date('Y-m-d',strtotime($originalDate.'+'.$i.' days'));
                $day = date('D',strtotime($originalDay.'+'.$i.' days'));
                $getSlots = Schedule::where('teacherId',$req->teacherId)->where('date',$date)/*->where('available',1)*/->get();
                $daysData[] = [
                    'date' => $date,
                    'day' => $day,
                    'short_date' => date('d',strtotime($date)),
                    'available' => $getSlots,
                ];
            }
            $response = [
                'from_date' => date('M, d Y',strtotime($originalDate)),
                'to_date' => date('M, d Y',strtotime($date)),
                'next_date' => '',
                'previous_date' => '',
                'slots' => $daysData,
            ];
            return sendResponse('Available Slots',$response);
        }
        return errorResponse($validator->errors()->first());
    }

    public function saveTeacherSchedule(Request $req)
    {
        $rules = [
            'teacherId' => 'required|min:1|numeric',
            'date' => 'required',
            'time' => 'required',
            'available' => 'required',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            Schedule::where('teacherId',$req->teacherId)->where('available','!=',2)->delete();
            $date = explode('@rajeev@', $req->date);
            $time = explode('@rajeev@', $req->time);
            $available = explode('@rajeev@', $req->available);
            foreach($date as $key => $eventData){
                if($eventData != ''){
                    $newSchedule = new Schedule();
                    $newSchedule->teacherId = $req->teacherId;
                    $newSchedule->date = date('Y-m-d',strtotime($date[$key]));
                    $newSchedule->time = date('H:i',strtotime($time[$key]));
                    $newSchedule->available = ($available[$key] == 'true') ? 1 : 0;
                    $newSchedule->save();
                }
            }
            return sendResponse('Scheduled Data Saved Success');
        }
        return errorResponse($validator->errors()->first());
    }

    public function changeUserPassword(Request $req)
    {
        if(!empty($req->userId)){
          if(!empty($req->password) && !empty($req->confirmpassword)){
            if($req->password == $req->confirmpassword){
              $user = User::where('id',$req->userId)->first();
              if($user){
                $user->password = Hash::make($req->password);
                $user->save();
                return sendResponse('Password Updated Success');
              }
              return errorResponse('Invalid User id');
            }
            return errorResponse('password and confirm password should be same');
          }
          return errorResponse('password and confirm password is required');
        }
        return errorResponse('userId is required');
    }

    public function getUserSubscribedCourses(Request $req,$subscribtionId = 0)
    {
        if(!empty($req->userId)){
          $user = User::where('id',$req->userId)->first();
          if($user){
            $subscribedCourse = SubscribedCourses::select('subscribed_courses.*')
              ->where('subscribed_courses.user_id',$user->id)->with('courses')->with('features');
            if($subscribtionId > 0){
              $subscribedCourse = $subscribedCourse->where('subscribed_courses.id',$subscribtionId)->first();
            }else{
              $subscribedCourse = $subscribedCourse->get();
            }
            return sendResponse('Subscribed Courses List',$subscribedCourse);
          }
          return errorResponse('Invalid User Id');
        }
        return errorResponse('userId is required');
    }

    public function saveUserSubscribedCourses(Request $req)
    {
        if(!empty($req->userId) && !empty($req->courseId)){
          $user = User::where('id',$req->userId)->first();
          if($user){
            $course = Course::where('id',$req->courseId)->first();
            if($course){
                $checkSubscription = SubscribedCourses::where('user_id',$user->id)->where('course_id',$course->id)->first();
                if(!$checkSubscription){
                    $newSubscription = new SubscribedCourses();
                    $newSubscription->user_id = $user->id;
                    $newSubscription->course_id = $course->id;
                    $newSubscription->save();
                    return sendResponse('Course Subscribed Success',$newSubscription);
                }
                return errorResponse('This course is already subscribed by you');
            }
            return errorResponse('Invalid User Id');
          }
          return errorResponse('Invalid User Id');
        }
        return errorResponse('userId and courseId is required');
    }

    public function getHomeContent(Request $req)
    {
        $HomeContent = HomeContent::get();
        $data = [];
        foreach ($HomeContent as $content) {
            $data[$content->key][] = $content;
        }
        $data['category'] = Category::get();
        return sendResponse('Home Content',$data);
    }

    public function getSubjectCategory(Request $req)
    {
        $subjectCategory = SubjectCategory::select('*')->with('category');
        if(!empty($req->subjectCategoryId) && $req->subjectCategoryId > 0){
            $subjectCategory = $subjectCategory->where('id',$req->subjectCategoryId);
        }
        if(!empty($req->categoryId) && $req->categoryId > 0){
            $subjectCategory = $subjectCategory->where('categoryId',$req->categoryId);
        }
        $subjectCategory = $subjectCategory->get();
        return sendResponse('Subject category',$subjectCategory);
    }

    public function getChapter(Request $req)
    {
        $chapter = Chapter::select('*')->with('category')->with('subjectCategory')->with('subChapter');
        if(!empty($req->chapterId)){
          $chapter = $chapter->where('id',$req->chapterId);  
        }
        if(!empty($req->subjectCategoryId)){
          $chapter = $chapter->where('subjectCategoryId',$req->subjectCategoryId);  
        }
        $chapter = $chapter->get();
        return sendResponse('Chapter List',$chapter);
    }

    public function getQuestion(Request $req)
    {
        $question = Question::select('*')->with('chapter');
        if(!empty($req->subjectCategoryId)){
          $question = $question->where('subjectCategoryId',$req->subjectCategoryId);  
        }
        if(!empty($req->chapterId)){
          $question = $question->where('chapterId',$req->chapterId);
        }
        $question = $question->get();
        return sendResponse('Question List',$question);
    }

    public function get_teacher(Request $req,$teacherId = 0)
    {
        if($teacherId == 0){
          $teacher = Teacher::get();
        }else{
            $teacher = Teacher::where('id',$teacherId)->first();
            $teacher->teacherCourses = Course::get();
        }
        return sendResponse('Teacher List',$teacher);
    }

    public function getTeacherAvailableSlots(Request $req)
    {
        $rules = ['teacherId' => 'required|min:1|numeric'];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){

            $slots = '';
        }
        return errorResponse($validator->errors()->first());
    }

    public function get_course(Request $req,$courseId = 0)
    {
        if($courseId == 0){
            $course = Course::with('teacher')->get();
        }else{
            $course = Course::where('id',$courseId)->with('teacher')->first();
            $course->isUserSubscribed = false;
            if(!empty($req->userId) && $req->userId > 0){
              $checkSubscription = SubscribedCourses::where('user_id',$req->userId)->where('course_id',$course->id)->first();
              if($checkSubscription){
                $course->isUserSubscribed = true;
              }
            }
            $course->similarCourses = Course::where('id','!=',$courseId)->with('teacher')->get();
            $course->features = CourseFeature::where('course_id',$courseId)->get();
            $course->lectures = CourseLecture::where('course_id',$courseId)->get();
        }
        return sendResponse('Course List',$course);
        // return sendResponse('Course List',$req->all());
    }

    public function getMembership(Request $req)
    {
        $data['membership'] = Membership::where('is_active',1)->with('question')->get();
        $data['commonQuestion'] = CommonQuestion::where('membership_id',0)->get();
        return sendResponse('MemberShip List',$data);
    }

    public function contactUsFormSubmit(Request $req)
    {
        $rules = [
          'name' => 'required|string|max:200',
          'email' => 'required|email|string',
          'message' => 'required|string|max:255'
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $contact = new Contact();
            $contact->name = $req->name;
            $contact->email = $req->email;
            $contact->mobile = ($req->mobile) ? $req->mobile : '';
            $contact->message = $req->message;
            $contact->save();
            return sendResponse('Thankyou for contact with us we will contact you soon!');
        }
        return errorResponse($validator->errors()->first());
    }

  	public $successStatus = 200;
    public $errorStatus = 401;

  	public function city($stateid)
  	{
        $city = City::where('is_active',1)->where('state_id',$stateid)->get();
        return response()
            ->json(['message'=>'success','status'=>'1',"city"=>$city], $this->successStatus);
  	}

    public function checkcoupon($couponcode)
    {
        $code = $couponcode;
        $use_date = date("Y-m-d");
        $result = DB::select("select * from coupon_codes where coupon_code='$code'
            and (start_date<='$use_date' and end_date>='$use_date')");
        if (count($result) > 0) {
            $offer_type = $result[0]->offer_type;
            $offer_rate = $result[0]->offer_rate;
            return response()
          ->json(['message'=>'success','status'=>'1','offer_type'=>$offer_type,'offer_rate'=>$offer_rate], $this->successStatus);
        } else {
            return response()
          ->json(['message'=>'error','status'=>'0'], $this->successStatus);
        }
    }

    public function createStripeCharge(Request $req)
    {
        $rules = [
            'stripeToken' => 'required',
            'amount' => 'required',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            \Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
            $payment = \Stripe\Charge::create ([
                "amount" => 100 * $req->amount,
                "currency" => "usd",
                "source" => $req->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
            ]);
            if($payment->status == 'succeeded'){
                $stripe = new StripeTransaction;
                $stripe->transactionId = $payment->id;
                $stripe->balance_transaction = $payment->balance_transaction;
                $stripe->amount = $payment->amount;
                $stripe->description = $payment->description;
                $stripe->payment_method = $payment->payment_method;
                $stripe->card_type = $payment->payment_method_details->type;
                $stripe->exp_month = $payment->payment_method_details->card->exp_month;
                $stripe->exp_year = $payment->payment_method_details->card->exp_year;
                $stripe->last4 = $payment->payment_method_details->card->last4;
                $stripe->save();
                return response()->json(['error'=>false,'data'=>$stripe]);
            }
            return errorResponse('Payment Failed Please try again');
        }
        return errorResponse($validator->errors()->first());
        // return back();
    }

    public function bookTheSlot(Request $req)
    {
        $rules = [
            'stripeTransactionId' => 'required|numeric|min:1',
            'slotId' => 'required|numeric|min:1',
            'userId' => 'required|numeric|min:1'
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $stripe = StripeTransaction::where('id',$req->stripeTransactionId)->first();
            $slot = Schedule::where('id',$req->slotId)->first();
            $booking = new TeacherBooking();
            $booking->stripeTransactionId = $stripe->id;
            $booking->userId = $req->userId;
            $booking->teacherId = $slot->teacherId;
            $booking->scheduleId = $slot->id;
            $booking->price = $stripe->amount;
            $booking->save();
            $slot->available = 2;
            $slot->save();
            $data = [
                'stripe' => $stripe,
                'Schedule' => $slot,
                'booking' => $booking,
            ];
            return response()->json(['error'=>false,'data'=>$data]);
        }
        return errorResponse($validator->errors()->first());
    }

    public function getBookingHistory(Request $req)
    {
        $data = TeacherBooking::select('*')->with('userInfo')->with('slotInfo');
        if(!empty($req->teacherId)){
            $data = $data->where('teacherId',$req->teacherId);
        }
        $data = $data->orderBy('id','desc')->get();
        return response()->json(['error'=>false,'data'=>$data]);
    }

    public function getPaymentHistory(Request $req)
    {
        $data = TeacherBooking::select('*')->with('teacherInfo')->with('slotInfo');
        if(!empty($req->userId)){
            $data = $data->where('userId',$req->userId);
        }
        $data = $data->orderBy('id','desc')->get();
        return response()->json(['error'=>false,'data'=>$data]);
    }
}
