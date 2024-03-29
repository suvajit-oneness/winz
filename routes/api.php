<?php

use Illuminate\Http\Request;

// header('Access-Control-Allow-Origin: *');
// header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::group(['middleware'=>'cors'],function(){ // Cors Middleware

	Route::middleware('auth:api')->get('/user', function (Request $request) {
	    return $request->user();
	});

	Route::get('city/{id}', 'Api\Apicontroller@city');
	Route::get('coupon/{couponcode}', 'Api\Apicontroller@checkcoupon');

	Route::group(['prefix'=>'v1'],function(){
		Route::get('home_page_content','Api\Apicontroller@getHomeContent');
		Route::get('course/list','Api\Apicontroller@getCourses');
		Route::post('login','Api\LoginController@UserLogin');
		Route::post('signup','Api\LoginController@userSignUP');
		Route::post('update_profile','Api\Apicontroller@updateProfile');
		Route::post('change/password','Api\Apicontroller@changeUserPassword');
		// Route::get('subscribed/course/{subscribedId?}','Api\Apicontroller@getUserSubscribedCourses');
		Route::post('subscribed/user/course','Api\Apicontroller@saveUserSubscribedCourses');
		Route::get('teacher/details','Api\Apicontroller@getTeacherDetails');
		Route::get('membership','Api\Apicontroller@getMembership');
		Route::get('subject-category','Api\Apicontroller@getSubjectCategory');
		Route::get('chapter','Api\Apicontroller@getChapter');

		Route::get('question/edit/{questionId}','Api\Apicontroller@getParticularQuestion');
		Route::get('question/list','Api\Apicontroller@getQuestionList');
		Route::post('create-and-update-question','Api\Apicontroller@createAndUpdateQuestion');

		Route::get('scheduled-teacher-data','Api\Apicontroller@getScheduledData');
		Route::post('scheduled-teacher-data/save','Api\Apicontroller@saveTeacherSchedule');
		Route::get('teacher-slots','Api\Apicontroller@getTeacherSlots');
		Route::post('contact-us','Api\Apicontroller@contactUsFormSubmit');
		Route::post('create-stripe-charge/by-token','Api\Apicontroller@createStripeCharge');
		Route::post('purchaseBookingSlot-mentor','Api\Apicontroller@bookTheSlot');
		Route::get('booking-history','Api\Apicontroller@getBookingHistory');
		Route::get('slot-booking-history','Api\Apicontroller@getPaymentHistory');
		Route::post('buy_membership','Api\Apicontroller@bookMembership');
		Route::get('user-membership-details','Api\Apicontroller@getUserMemberShip');
		// Zoom Meeting
		Route::group(['prefix' => 'zoom'],function(){
			Route::get('meetings','Api\Apicontroller@getMeetings')->name('zoom.meetings');
			// Route::post('meeting','Api\ZoomMeetingController@createMeeting')->name('zoom.meeting.save');
			// Route::post('meeting/delete','Api\ZoomMeetingController@deleteZoomMeeting')->name('zoom.meeting.delete');
		});
		Route::get('teacher/course/list','Api\Apicontroller@getTeacherCourseList')->name('api.course.list');
		Route::post('teacher/course/delete','Api\Apicontroller@deleteTeacherCourse')->name('api.course.list');
		Route::get('category/list','Api\Apicontroller@getCategoryList')->name('api.category.list');
		Route::post('course/chapter/create','Api\Apicontroller@createNewChapter')->name('chapter.create');
		Route::post('chapter/update','Api\Apicontroller@updateChapter')->name('chapter.update');
		Route::post('chapter/delete','Api\Apicontroller@deleteChapter')->name('chapter.delete');
		Route::post('chapter/purchase/success','Api\Apicontroller@chapterPurchaseSuccess')->name('chapter.purchase.success');

		Route::get('contact-us-data','Api\Apicontroller@getContactDataToShow');

		Route::get('subscribed/user/chapter','Api\Apicontroller@subscribedUserChapter')->name('subscribed.user.chapter');

		Route::get('testimonials','Api\Apicontroller@getTestimonials');
		Route::get('blogs','Api\Apicontroller@getBlogs');
		Route::get('settings','Api\Apicontroller@getSettings');

		// new Routes
		Route::post('teacher/course/create','Api\Apicontroller@saveTeacherCourse');
		Route::get('teacher/course/edit','Api\Apicontroller@editTeacherCourse');
		Route::get('chapter/subchapter','Api\Apicontroller@getSubChapters');
		Route::post('subchapter/delete','Api\Apicontroller@deleteSubChapters');
		Route::get('sub-chapter/create','Api\Apicontroller@createSubChapterForm');
		Route::post('chapter/subchapter/create','Api\Apicontroller@saveOrUpdateSubChapterForm');
		Route::post('delete_question_api','Api\Apicontroller@deleteQuestionAPI');

	});

	// stripePayment
	// Route::get('stripe/{amount?}', 'StripePaymentController@stripe');
	// Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
	// Route::get('stripe/{Id}/success','StripePaymentController@successTransaction')->name('stripe.success');
	
});

