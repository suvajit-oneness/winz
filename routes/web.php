<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Route::get('cache-clear',function(){
	Artisan::call('config:cache');
	Artisan::call('config:clear');
	Artisan::call('view:clear');
	Artisan::call('route:clear');
	Artisan::call('key:generate');
	dd('Done');
});

Route::get('/',function(){
	return redirect('admin/login');
});

Auth::routes(['verify' => true]);

require 'admin.php';

/*=======================web-site============================*/