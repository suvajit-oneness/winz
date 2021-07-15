<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;use App\Models\Schedule;
use App\Models\City;use Auth;use Hash;use App\Models\Chapter;
use Illuminate\Http\Request;use App\Models\SubjectCategory;
use App\Models\Category;use Session;use App\Models\SubChapter;
use Illuminate\Support\Facades\DB;use App\Models\Question;
use URL;use Validator;use App\Models\CommonQuestion;use App\Models\ZoomMeeting;
use App\Models\Course;use App\Models\Teacher;use App\Models\Membership;
use App\Models\HomeContent;use App\Models\CourseLecture;use App\Models\CourseFeature;
use App\Models\User;use App\Models\SubscribedCourses;use App\Models\TeacherCourse;
use Stripe;use App\Models\StripeTransaction;use App\Models\TeacherBooking;
use App\Models\BuyMemberShip;use App\Models\ContactUs;use App\Models\Testimonial;
use App\Models\Blog;use App\Models\Setting;use App\Models\ChapterPurchase;
// header('Access-Control-Allow-Origin: *');
// header('Content-Type:application/json');

class Apicontroller extends Controller
{
    public function getHomeContent(Request $req)
    {
        $HomeContent = HomeContent::get();
        $data = [];
        foreach ($HomeContent as $content) {
            $data[$content->key][] = $content;
        }
        $data['teacherList'] = Teacher::limit(4)->get();
        $data['courseList'] = Course::where('is_verified',1)->with('teacher')->limit(4)->get();
        return sendResponse('Home Content',$data);
    }

    public function getCourses(Request $req)
    {
        if(!empty($req->courseId)){
            $course = Course::where('id',$req->courseId)->where('is_verified',1)->with('teacher')->first();
            $course->isUserCoursePurchased = false;
            $course->chapter = Chapter::where('courseId',$course->id)->get();
            $coursePrice = $course->chapter->sum('price');
            if(!empty($req->userId) && $req->userId > 0){
                $coursePrice = 0;
                foreach ($course->chapter as $key => $chapter) {
                    $chapter->userChapterPurchases = false;
                    $purchase = ChapterPurchase::where('userId',$req->userId)->where('chapterId',$chapter->id)->where('courseId',$chapter->courseId)->first();
                    if($purchase){
                        $chapter->userChapterPurchases = true;
                    }else{
                        $coursePrice += $chapter->price;
                    }
                }
                if($coursePrice == 0){
                    $course->isUserCoursePurchased = true;
                    $coursePrice = $course->chapter->sum('price');
                }
            }
            $course->coursePrice = $coursePrice;
            $course->similarCourses = Course::where('id','!=',$course->id)->with('teacher')->get();
            $course->features = CourseFeature::where('course_id',$course->id)->get();
        }else{
            $course = Course::where('is_verified',1)->with('teacher')->get();
        }
        return sendResponse('Course List',$course);
    }

    public function getTeacherDetails(Request $req)
    {
        if(!empty($req->teacherId)){
            $teacher = Teacher::where('id',$req->teacherId)->first();
            $teacher->teacherCourses = Course::where('teacherId',$teacher->id)->where('is_verified',1)->get();
        }else{
            $teacher = Teacher::select('*')->get();
        }
        return sendResponse('Teacher List',$teacher);
    }

    public function saveUserSubscribedCourses(Request $req)
    {
        $rules = [
            'userId' => 'required|numeric|min:1',
            'courseId' => 'required|numeric|min:1',
            'whatPurchased' => 'required|in:chapter,course',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $user = User::where('id',$req->userId)->first();
            if($user){
                $course = Course::where('id',$req->courseId)->first();
                if($course){
                    DB::beginTransaction();
                    $transaction = new StripeTransaction();
                    $transaction->transactionId = randomGenerator();
                    $transaction->balance_transaction = randomGenerator();
                    $transaction->amount = 0;
                    $transaction->payment_method = 'free';
                    $transaction->save();
                    if($req->whatPurchased == 'chapter'){
                        $rules = [
                            'chapterId' => 'required|numeric|min:1',
                        ];
                        $validator = validator()->make($req->all(),$rules);
                        if(!$validator->fails()){
                            $chapter = Chapter::where('id',$req->chapterId)->where('courseId',$course->id)->first();
                            if($chapter){
                                $checkSubscription = ChapterPurchase::where('userId',$req->userId)->where('chapterId',$chapter->id)->where('courseId',$course->id)->first();
                                if(!$checkSubscription){
                                    $newChapterPurchased = new ChapterPurchase();
                                    $newChapterPurchased->userId = $user->id;
                                    $newChapterPurchased->chapterId = $chapter->id;
                                    $newChapterPurchased->courseId = $course->id;
                                    $newChapterPurchased->price = $chapter->price;
                                    $newChapterPurchased->stripeTransactionId = $transaction->id;
                                    $newChapterPurchased->save();
                                    DB::commit();
                                    return sendResponse('Chapter Purchased Success',$newChapterPurchased);
                                }
                                return errorResponse('This Chapter is already Purchased by you');
                            }
                            return errorResponse('Invalid Chapter Id');
                        }
                        return errorResponse($validator->errors()->first());
                    }else{
                        $chapter = Chapter::where('courseId',$course->id)->get();
                        foreach ($chapter as $key => $chap) {
                            $checkSubscription = ChapterPurchase::where('userId',$req->userId)->where('chapterId',$chap->id)->where('courseId',$course->id)->first();
                            if(!$checkSubscription){
                                $newChapterPurchased = new ChapterPurchase();
                                $newChapterPurchased->userId = $user->id;
                                $newChapterPurchased->chapterId = $chap->id;
                                $newChapterPurchased->courseId = $course->id;
                                $newChapterPurchased->price = $chap->price;
                                $newChapterPurchased->stripeTransactionId = $transaction->id;
                                $newChapterPurchased->save();
                            }
                        }
                        DB::commit();
                        return sendResponse('Chapter Purchased Success',$newChapterPurchased);
                    }
                }
                return errorResponse('Invalid Course Id');
            }
            return errorResponse('Invalid User Id');
        }
        return errorResponse($validator->errors()->first());
    }

    public function subscribedUserChapter(Request $req)
    {
        $purchaseChapter = ChapterPurchase::select('*')->with('transaction')->with('chapter')->with('course');
        if(!empty($req->userId)){
            $user = User::where('id',$req->userId)->first();
            $purchaseChapter = $purchaseChapter->where('userId',$user->id);
        }
        $purchaseChapter = $purchaseChapter->get();
        foreach($purchaseChapter as $key => $getCategoryAndTeacher){
            // $getCategoryAndTeacher->category = Category::where('id',$getCategoryAndTeacher->course->categoryId)->first();
            $getCategoryAndTeacher->teacher = Teacher::where('id',$getCategoryAndTeacher->course->teacherId)->first();
        }
        return sendResponse('Purchse Chapter List',$purchaseChapter);
    }

    public function getTeacherCourseList(Request $req)
    {
        $teacherCourse = Course::select('*')->with('chapter')->with('category')->with('feature');
        if($req->teacherId){
            $teacherCourse = $teacherCourse->where('teacherId',$req->teacherId);
        }
        $teacherCourse = $teacherCourse->get();
        foreach ($teacherCourse as $key => $course) {
            $chapterPrice = Chapter::where('courseId',$course->id)->sum('price');
            $course->price = number_format($chapterPrice,2);
        }
        return sendResponse('Teacher Course List',$teacherCourse);
    }

    public function editTeacherCourse(Request $req)
    {
        $course = Course::where('id',$req->courseId)->with('chapter')->first();
        return sendResponse('Course',$course);
    }

    public function saveTeacherCourse(Request $req)
    {
        $rules = [
            'formType' => 'required|in:add,edit',
            'description' => 'required|string',
            'teacherId' => 'required|numeric|min:1',
            'image' => '',
            'name' => 'required|string|max:255',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            if($req->formType == 'add'){
                $newCourse = new Course();
                $newCourse->teacherId = $req->teacherId;
                $newCourse->course_name = $req->name;
                if($req->hasFile('image')){
                    $image = $req->file('image');
                    $newCourse->course_image = imageUpload($image,'courses');
                }
                $newCourse->course_description = $req->description;
                $newCourse->is_verified = 0;
                $newCourse->save();
                return sendResponse('Course Created Success',$newCourse);
            }else{
                $rules = [
                    'courseId' => 'required|numeric|min:1',
                ];
                $validator = validator()->make($req->all(),$rules);
                if(!$validator->fails()){
                    $update = Course::where('id',$req->courseId)->where('teacherId',$req->teacherId)->first();
                    if($update){
                        $update->course_name = $req->name;
                        if($req->hasFile('image')){
                            $image = $req->file('image');
                            $update->course_image = imageUpload($image,'courses');
                        }
                        $update->course_description = $req->description;
                        $update->save();
                        return sendResponse('Course Updated Success',$update);
                    }
                    return errorResponse('Invalid Request Found');
                }
            }
        }
        return errorResponse($validator->errors()->first());
    }

    public function deleteTeacherCourse(Request $req)
    {
        $rules = [
            'teacherId' => 'required|numeric|min:1',
            'courseId' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $course = Course::where('id',$req->courseId)->where('teacherId',$req->teacherId)->first();
            if($course){
                $course->delete();
                return sendResponse('Chapter Deleted Successfully');
            }
            return errorResponse('Invalid Course Details');
        }
        return errorResponse($validator->errors()->first());
    }

    // public function getUserSubscribedCourses(Request $req,$subscribtionId = 0)
    // {
    //     if(!empty($req->userId)){
    //       $user = User::where('id',$req->userId)->first();
    //       if($user){
    //         $chapter = ChapterPurchase::whare('userId',$user->id)->with('chapter')->with('course')->with('trasaction')->get();
    //         return sendResponse('Subscribed Courses List',$subscribedCourse);
    //       }
    //       return errorResponse('Invalid User Id');
    //     }
    //     return errorResponse('userId is required');
    // }

    // public function chapterPurchaseSuccess(Request $req)
    // {
    //     $rules = [
    //         'userId' => 'required|numeric|min:1',
    //         'chapterId' => 'required|numeric|min:1',
    //         'stripeTransactionId' => 'required|numeric|min:1',
    //     ];
    //     $validator = validator()->make($req->all(),$rules);
    //     if(!$validator->fails()){
    //         DB::beginTransaction();
    //         try{
    //             $chapter = Chapter::where('id',$req->chapterId)->with('subChapter')->first();
    //             if($chapter){
    //                 $stripe = StripeTransaction::where('id',$req->stripeTransactionId)->first();
    //                 if($stripe){
    //                     $purchaseCheck = ChapterPurchase::where('userId',$req->userId)->where('chapterId',$chapter->id)->first();
    //                     if(!$purchaseCheck){
    //                         $purchase = new ChapterPurchase();
    //                             $purchase->userId = $req->userId;
    //                             $purchase->chapterId = $req->chapterId;
    //                             $purchase->stripeTransactionId = $req->stripeTransactionId;
    //                         $purchase->save();
    //                         DB::commit();
    //                         $data = [
    //                             'purchase' => $purchase,
    //                             'chapter' => $chapter,
    //                             'stripe' => $stripe,
    //                         ];
    //                         return sendResponse('Chapter Purchased Successfully',$data);
    //                     }
    //                     return errorResponse('This Chapter is already purchased');
    //                 }
    //                 return errorResponse('Invalid Stripe Transaction Id');
    //             }
    //         }catch(Exception $e){
    //             DB::rollback();
    //         }
    //         return errorResponse('Something Went Wrong Please try after Some time');
    //     }
    //     return errorResponse($validator->errors()->first());
    // }

    public function getCategoryList(Request $req)
    {
        $data['category'] = Category::get();
        return sendResponse('Category List',$data);
    }

    public function createNewChapter(Request $req)
    {
        $rules = [
            'formType' => 'required|in:add,edit',
            'courseId' => 'required|numeric|min:1',
            'teacherId' => 'required|numeric|min:1',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|max:99999',
            'description' => 'required|string',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            DB::beginTransaction();
            $course = Course::where('id',$req->courseId)->where('teacherId',$req->teacherId)->first();
            if($course){
                if($req->formType == 'add'){
                    $newChapter = new Chapter();
                        $newChapter->courseId = $course->id;
                        $newChapter->name = $req->name;
                        $newChapter->description = $req->description;
                        $newChapter->price = $req->price;
                    $newChapter->save();
                    DB::commit();
                    return sendResponse('Chapter Added Success',$newChapter);
                }else{
                    $rules = [
                        'chapterId' => 'required|numeric|min:1',
                    ];
                    $validator = validator()->make($req->all(),$rules);
                    if(!$validator->fails()){
                        $chapter = Chapter::where('id',$req->chapterId)->where('courseId',$course->id)->first();
                        if($chapter){
                            $chapter->name = $req->name;
                            $chapter->description = $req->description;
                            $chapter->price = $req->price;
                            $chapter->save();
                            DB::commit();
                            return sendResponse('Chapter Updated Success',$chapter);
                        }
                        return errorResponse('Invalid request Found');
                    }
                    return errorResponse($validator->errors()->first());
                }
            }
            return errorResponse('Invalid request Found');
        }
        return errorResponse($validator->errors()->first());
    }

    public function updateChapter(Request $req)
    {
        $rules = [
            'teacherId' => 'nullable|numeric|min:1',
            'chapterId' => 'required|numeric|min:1',
            'category' => 'required|min:1|numeric',
            'subcategory' => 'required|min:1|numeric',
            'chapter' => 'required|string|max:200',
            'price' => 'required|numeric|max:99999',
            'title' => 'required|array',
            'title.*' => 'required|string|max:200',
            'topic' => 'required|array',
            'topic.*' => 'required|string|max:200',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            DB::beginTransaction();
            try{
                $chapter = Chapter::where('id',$req->chapterId)->first();
                if($chapter){
                    $chapter->categoryId = $req->category;
                    $chapter->subjectCategoryId = $req->subcategory;
                    $chapter->chapter = $req->chapter;
                    $chapter->price = $req->price;
                    $chapter->save();
                    SubChapter::where('chapterId',$chapter->id)->delete();
                    foreach($req->title as $key => $title){
                        $SubTopic = new SubChapter();
                            $SubTopic->chapterId = $chapter->id;
                            $SubTopic->name = $title;
                            $SubTopic->topics = $req->topic[$key];
                        $SubTopic->save();
                    }
                    DB::commit();
                    return sendResponse('Chapter Updated Success');
                }
            }catch(Exception $e){
                DB::rollback();
            }
            return errorResponse('Something Went Wrong Please try after Some time');
        }
        return errorResponse($validator->errors()->first());
    }

    public function deleteChapter(Request $req)
    {
        $rules = [
            'teacherId' => 'nullable|numeric|min:1',
            'chapterId' => 'required|numeric|min:1',
            'courseId' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            DB::beginTransaction();
            try{
                $chapter = Chapter::where('id',$req->chapterId)->where('courseId',$req->courseId)->first();
                if($chapter){
                    $chapter->delete();
                    DB::commit();
                    return sendResponse('Chapter Deleted Success');
                }
            }catch(Exception $e){
                DB::rollback();
            }
            return errorResponse('Something Went Wrong Please try after Some time');
        }
        return errorResponse($validator->errors()->first());
    }

    public function getSubChapters(Request $req)
    {
        $subchapter = SubChapter::select('*')->with('chapter')->with('category');
        if(!empty($req->categoryId)){
            $subchapter = $subchapter->where('categoryId',$req->categoryId);
        }
        if(!empty($req->chapterId)){
            $subchapter = $subchapter->where('chapterId',$req->chapterId);
        }
        $subchapter = $subchapter->get();
        return sendResponse('Sub-Chapter List',$subchapter);
    }

    public function getTestimonials(Request $req)
    {
        $testimonials = Testimonial::where('is_active',1);
        if(!empty($req->id)){
            $testimonials = $testimonials->where('id',$req->id);
        }
        $testimonials = $testimonials->orderBy('id','DESC')->get();
        return sendResponse('Testimonials List',$testimonials);
    }

    public function getBlogs(Request $req)
    {
        $blogs = Blog::where('is_active',1);
        if(!empty($req->id)){
            $blogs = $blogs->where('id',$req->id);
        }
        $blogs = $blogs->orderBy('id','DESC')->get();
        return sendResponse('Blogs List',$blogs);
    }

    public function getSettings(Request $req)
    {
        $setting = Setting::select('*');
        if(!empty($req->key)){
            $setting = $setting->where('key',$req->key);
        }
        $setting = $setting->orderBy('id','DESC')->get();
        return sendResponse('Setting',$setting);
    }

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
                        $teacher->price_per_hour = ($req->price) ? $req->price : 50;
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
        if(!empty($req->teacherId)){

        }
        $chapter = $chapter->get();
        foreach ($chapter as $key => $chap) {
            $chap->userChapterPurchased = false;
            if(!empty($req->userId)){
                $purchaseChapter = ChapterPurchase::where('userId',$req->userId)->where('chapterId',$chap->id)->first();
                if($purchaseChapter){$chap->userChapterPurchased = true;}
            }
        }
        return sendResponse('Chapter List',$chapter);
    }

    public function getQuestionList(Request $req)
    {
        $rules = [
            'chapterId' => 'required|min:1|numeric',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $chapter = Chapter::where('id',$req->chapterId)->first();
            if($chapter){
                $question = Question::select('*')->with('chapter')->with('category')->with('subchapter');
                if(!empty($req->categoryId)){
                    $question = $question->where('categoryId',$req->categoryId);
                }
                if(!empty($req->chapterId)){
                    $question = $question->where('chapterId',$req->chapterId);
                }
                if(!empty($req->subChapterId)){
                    $question = $question->where('subChapterId',$req->subChapterId);
                }
                $question = $question->orderBy('difficulty')->get();
                return sendResponse('Question List',$question);
            }
            return errorResponse('Invalid Request Found');
        }
        return errorResponse($validator->errors()->first());
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

    public function getMembership(Request $req)
    {
        $data['commonQuestion'] = CommonQuestion::where('membership_id',0)->get();
        $data['membership'] = Membership::where('is_active',1)->with('question')->get();
        if((!empty($req->userId) && $req->userId > 0) && !empty($req->userType)){
            foreach ($data['membership'] as $key => $getMembership) {
                $getMembership->enrolledment = BuyMemberShip::where('membershipId',$getMembership->id)->where('userId',$req->userId)->where('userType',$req->userType)->first();
            }
        }
        return sendResponse('MemberShip List',$data);
    }

    public function getUserMemberShip(Request $req)
    {
        $memberShip = BuyMemberShip::select('*')->with('membership')->with('transactionDetails');
        if(!empty($req->userId)){
            $memberShip = $memberShip->where('userId',$req->userId);
        }
        if(!empty($req->userType)){
            $memberShip = $memberShip->where('userType',$req->userType);
        }
        $memberShip = $memberShip->get();
        return sendResponse('MemberShip List of The User',$memberShip);
    }

    public function getContactDataToShow(Request $req)
    {
        $contact = ContactUs::where('type',1)->first();
        return sendResponse('Contact Data',$contact);
    }

    public function contactUsFormSubmit(Request $req)
    {
        $rules = [
          'name' => 'required|string|max:200',
          'email' => 'required|email|string',
          'subject' => 'required|string|max:200',
          'message' => 'required|string|max:255'
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $contact = new ContactUs();
            $contact->name = $req->name;
            $contact->type = 2;
            $contact->email = $req->email;
            $contact->mobile = ($req->mobile) ? $req->mobile : '';
            $contact->subject = $req->subject;
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
    }

    public function bookTheSlot(Request $req)
    {
        $rules = [
            'stripeTransactionId' => 'required|numeric|min:1',
            'slotId' => 'required|numeric|min:1',
            'userId' => 'required|numeric|min:1',
            'userType' => 'required|string|in:user,teacher',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            DB::beginTransaction();
            try {
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
                $this->createZoomMeeting($booking,$slot,$req->userType);
                DB::commit();
                return sendResponse('Slot Booked Success',$data);
            }catch (Exception $e) {
                DB::rollback();
                return errorResponse('Something went wring please try after some time');
            }
        }
        return errorResponse($validator->errors()->first());
    }

    // Zoom Meeting Integration
    public function createZoomMeeting($bookingData,$slotData,$userType)
    {
        $getTeacherDetails = Teacher::where('id',$bookingData->teacherId)->first();
        $topic = 'Meeting with '.$getTeacherDetails->name.' at '.$slotData->date. ' '.$slotData->time;
        $startTime = date('Y-m-d',strtotime($slotData->date)).' '.date('h:i:s',strtotime($slotData->time));

        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer " . $this->generateToken(),
            ],
            'json' => [
                "topic" => $topic,
                "type" => 2,
                "start_time" => $startTime,
                "duration" => "30", // 30 mins
                "password" => "123456",
                "agenda" => 'Scheduled Class',
            ],
        ]);
        $data = json_decode($response->getBody());
        if($data){
            $newMeeting = new ZoomMeeting;
            $newMeeting->teacherId = $bookingData->teacherId;
            $newMeeting->userType = $userType;
            $newMeeting->userId = $bookingData->userId;
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

    public function getMeetings(Request $req)
    {
        // return errorResponse('',$req->all());
        $rules = [
            'userId' => 'required|min:1|numeric',
            'userType' => 'required|in:user,teacher|string',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $zoom = ZoomMeeting::select('*')->with('userData')->with('teacherData');
            if($req->userType == 'teacher'){
                $teacher = Teacher::where('userId',$req->userId)->first();
                $zoom = $zoom->where('teacherId',$teacher->id);
            }elseif($req->userType == 'user'){
                $zoom = $zoom->where('userId',$req->userId);
            }
            $zoom = $zoom->orderBy('id')->get();
            return sendResponse('Zoom Meeting Data',$zoom);
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

    public function bookMembership(Request $req)
    {
        $rules = [
            'stripeTransactionId' => 'required|min:1|numeric',
            'membershipId' => 'required|min:1|numeric',
            'userId' => 'required|min:1|numeric',
            'userType' => 'required|string|in:user,teacher',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $stripe = StripeTransaction::where('id',$req->stripeTransactionId)->first();
            $membership = Membership::where('id',$req->membershipId)->first();
            $buyMemberShip = new BuyMemberShip();
            $buyMemberShip->stripeTransactionId = $req->stripeTransactionId;
            $buyMemberShip->membershipId = $req->membershipId;
            $buyMemberShip->userId = $req->userId;
            $buyMemberShip->userType = $req->userType;
            $buyMemberShip->price = $stripe->amount;
            $buyMemberShip->save();
            $data = [
                'purchase' => $buyMemberShip,
                'membership' => $membership,
                'stripe' => $stripe,
            ];
            return sendResponse('Booking Success',$data);
        }
        return errorResponse($validator->errors()->first());
    }
}
