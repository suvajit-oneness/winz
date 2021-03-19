<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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
	Route::get('scheduled-user-data','Api\Apicontroller@getScheduledData');
	Route::post('scheduled-user-data/save','Api\Apicontroller@saveUserSchedule');
	
	Route::post('contact-us','Api\Apicontroller@contactUsFormSubmit');
});