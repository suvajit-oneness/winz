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
		Route::post('login','Api\LoginController@UserLogin');
		Route::post('signup','Api\LoginController@userSignUP');
		Route::post('update_profile','Api\Apicontroller@updateProfile');
		Route::post('change/password','Api\Apicontroller@changeUserPassword');
		Route::get('subscribed/course/{subscribedId?}','Api\Apicontroller@getUserSubscribedCourses');
		Route::post('subscribed/course','Api\Apicontroller@saveUserSubscribedCourses');
		Route::get('teacher/{teacherId?}','Api\Apicontroller@get_teacher');
		Route::get('course/{courseId?}','Api\Apicontroller@get_course');
		Route::get('membership','Api\Apicontroller@getMembership');
		Route::get('subject-category','Api\Apicontroller@getSubjectCategory');
		Route::get('chapter','Api\Apicontroller@getChapter');
		Route::get('question','Api\Apicontroller@getQuestion');
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

		Route::get('contact-us-data','Api\Apicontroller@getContactDataToShow');

		Route::get('testimonials','Api\Apicontroller@getTestimonials');
		Route::get('blogs','Api\Apicontroller@getBlogs');
		Route::get('settings','Api\Apicontroller@getSettings');

	});

	// stripePayment
	// Route::get('stripe/{amount?}', 'StripePaymentController@stripe');
	// Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
	// Route::get('stripe/{Id}/success','StripePaymentController@successTransaction')->name('stripe.success');
	
});

