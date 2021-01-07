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
	Route::get('teacher/{teacherId?}','Api\Apicontroller@get_teacher');
	Route::get('course/{courseId?}','Api\Apicontroller@get_course');
});