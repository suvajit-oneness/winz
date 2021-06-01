<?php

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
	Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
	
	//admin password reset routes
	Route::get('/password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('/register', 'Admin\RegisterController@register')->name('admin.register.post');

    Route::group(['middleware' => ['auth:admin']], function () {

    	Route::get('/dashboard', 'Admin\LoginController@index')->name('admin.dashboard');

		Route::get('/invite_list', 'Admin\InvitationController@index')->name('admin.invite');
	    Route::get('/invitation', 'Admin\InvitationController@create')->name('admin.invite.create');
		Route::post('/invitation', 'Admin\InvitationController@store')->name('admin.invitation.store');
		Route::get('/adminuser', 'Admin\AdminUserController@index')->name('admin.adminuser');
		Route::post('/adminuser', 'Admin\AdminUserController@updateAdminUser')->name('admin.adminuser.update');
	    Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
		Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');
		
		Route::get('/profile', 'Admin\ProfileController@index')->name('admin.profile');
		Route::post('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');
		Route::post('/changepassword', 'Admin\ProfileController@changePassword')->name('admin.profile.changepassword');

		Route::group(['prefix'  =>   'board'], function() {
			Route::get('/', 'Admin\BoardController@index')->name('admin.board.index');
			Route::get('/create', 'Admin\BoardController@create')->name('admin.board.create');
			Route::post('/store', 'Admin\BoardController@store')->name('admin.board.store');
			Route::get('/{id}/edit', 'Admin\BoardController@edit')->name('admin.board.edit');
			Route::post('/update', 'Admin\BoardController@update')->name('admin.board.update');
			Route::get('/{id}/delete', 'Admin\BoardController@delete')->name('admin.board.delete');
			Route::post('updateStatus', 'Admin\BoardController@updateStatus')->name('admin.board.updateStatus');
		});

		Route::group(['prefix'  => 'size'], function() {
			Route::get('/', 'Admin\SizeController@index')->name('admin.size.index');
			Route::get('/create', 'Admin\SizeController@create')->name('admin.size.create');
			Route::post('/store', 'Admin\SizeController@store')->name('admin.size.store');
			Route::get('/{id}/edit', 'Admin\SizeController@edit')->name('admin.size.edit');
			Route::post('/update', 'Admin\SizeController@update')->name('admin.size.update');
			Route::get('/{id}/delete', 'Admin\SizeController@delete')->name('admin.size.delete');
			Route::post('updateStatus', 'Admin\SizeController@updateStatus')->name('admin.size.updateStatus');
		});

		Route::group(['prefix'  => 'productstock'], function() {
			Route::get('/', 'Admin\ProductStockController@index')->name('admin.productstock.index');
			Route::get('/create', 'Admin\ProductStockController@create')->name('admin.productstock.create');
			Route::post('/store', 'Admin\ProductStockController@store')->name('admin.productstock.store');
			Route::get('/{id}/edit', 'Admin\ProductStockController@edit')->name('admin.productstock.edit');
			Route::post('/update', 'Admin\ProductStockController@update')->name('admin.productstock.update');
			Route::get('/{id}/delete', 'Admin\ProductStockController@delete')->name('admin.productstock.delete');
			Route::get('/sizes/{id}', 'Admin\ProductStockController@sizes')->name('admin.productstock.delete');
		});

		Route::group(['prefix'  => 'membership'], function() {
			Route::get('/', 'Admin\MembershipController@index')->name('admin.membership.index');
			Route::get('/create', 'Admin\MembershipController@create')->name('admin.membership.create');
			Route::post('/store', 'Admin\MembershipController@store')->name('admin.membership.store');
			Route::get('/{id}/edit', 'Admin\MembershipController@edit')->name('admin.membership.edit');
			Route::post('/update', 'Admin\MembershipController@update')->name('admin.membership.update');
			Route::get('/{id}/view', 'Admin\MembershipController@viewDetail')->name('admin.membership.detail');
			Route::get('/{id}/delete', 'Admin\MembershipController@delete')->name('admin.membership.delete');
			Route::post('updateStatus', 'Admin\MembershipController@updateStatus')->name('admin.membership.updateStatus');
		});
		
		Route::group(['prefix'  =>   'class'], function() {
			Route::get('/', 'Admin\ClassController@index')->name('admin.class.index');
			Route::get('/create', 'Admin\ClassController@create')->name('admin.class.create');
			Route::post('/store', 'Admin\ClassController@store')->name('admin.class.store');
			Route::get('/{id}/edit', 'Admin\ClassController@edit')->name('admin.class.edit');
			Route::post('/update', 'Admin\ClassController@update')->name('admin.class.update');
			Route::get('/{id}/delete', 'Admin\ClassController@delete')->name('admin.class.delete');
			Route::post('updateStatus', 'Admin\ClassController@updateStatus')->name('admin.class.updateStatus');
		});

		Route::group(['prefix'  => 'subject'], function() {
			Route::get('/', 'Admin\SubjectController@index')->name('admin.subject.index');
			Route::get('/create', 'Admin\SubjectController@create')->name('admin.subject.create');
			Route::post('/store', 'Admin\SubjectController@store')->name('admin.subject.store');
			Route::get('/{id}/edit', 'Admin\SubjectController@edit')->name('admin.subject.edit');
			Route::post('/update', 'Admin\SubjectController@update')->name('admin.subject.update');
			Route::get('/{id}/delete', 'Admin\SubjectController@delete')->name('admin.subject.delete');
			Route::post('updateStatus', 'Admin\SubjectController@updateStatus')->name('admin.subject.updateStatus');
		});

		Route::group(['prefix'  =>   'topic'], function() {
			Route::get('/', 'Admin\TopicController@index')->name('admin.topic.index');
			Route::get('/create', 'Admin\TopicController@create')->name('admin.topic.create');
			Route::post('/store', 'Admin\TopicController@store')->name('admin.topic.store');
			Route::get('/{id}/edit', 'Admin\TopicController@edit')->name('admin.topic.edit');
			Route::post('/update', 'Admin\TopicController@update')->name('admin.topic.update');
			Route::get('/{id}/delete', 'Admin\TopicController@delete')->name('admin.topic.delete');
			Route::post('updateStatus', 'Admin\TopicController@updateStatus')->name('admin.topic.updateStatus');
		});

		Route::group(['prefix'  =>   'subtopic'], function() {
			Route::get('/', 'Admin\SubtopicController@index')->name('admin.subtopic.index');
			Route::get('/create', 'Admin\SubtopicController@create')->name('admin.subtopic.create');
			Route::post('/store', 'Admin\SubtopicController@store')->name('admin.subtopic.store');
			Route::get('/{id}/edit', 'Admin\SubtopicController@edit')->name('admin.subtopic.edit');
			Route::post('/update', 'Admin\SubtopicController@update')->name('admin.subtopic.update');
			Route::get('/{id}/delete', 'Admin\SubtopicController@delete')->name('admin.subtopic.delete');
			Route::post('updateStatus', 'Admin\SubtopicController@updateStatus')->name('admin.subtopic.updateStatus');
		});

		Route::group(['prefix'  =>   'tutor'], function() {
			Route::get('/', 'Admin\TutorController@index')->name('admin.tutor.index');
			Route::get('/create', 'Admin\TutorController@create')->name('admin.tutor.create');
			Route::post('/store', 'Admin\TutorController@store')->name('admin.tutor.store');
			Route::get('/{id}/edit', 'Admin\TutorController@edit')->name('admin.tutor.edit');
			Route::post('/update', 'Admin\TutorController@update')->name('admin.tutor.update');
			Route::get('/{id}/delete', 'Admin\TutorController@delete')->name('admin.tutor.delete');
			Route::post('updateStatus', 'Admin\TutorController@updateStatus')->name('admin.tutor.updateStatus');
		});

		Route::group(['prefix'  =>   'products'], function() {
			Route::get('/', 'Admin\ProductsController@index')->name('admin.products.index');
			Route::get('/create', 'Admin\ProductsController@create')->name('admin.products.create');
			Route::post('/store', 'Admin\ProductsController@store')->name('admin.products.store');
			Route::get('/{id}/edit', 'Admin\ProductsController@edit')->name('admin.products.edit');
			Route::post('/update', 'Admin\ProductsController@update')->name('admin.products.update');
			Route::get('/{id}/view', 'Admin\ProductsController@viewDetail')->name('admin.products.detail');
			Route::get('/sizes/{id}', 'Admin\ProductsController@sizes')->name('admin.products.categorywisesize');

			Route::get('/{id}/delete', 'Admin\ProductsController@delete')->name('admin.products.delete');
			Route::post('updateStatus', 'Admin\ProductsController@updateStatus')->name('admin.products.updateStatus');
			Route::get('/{id}/{idd}/bestseller', 'Admin\ProductsController@bestseller')->name('admin.products.bestseller');

			Route::get('/{id}/{idd}/todaydeal', 'Admin\ProductsController@todaydeal')->name('admin.products.todaydeal');

			Route::get('/{id}/{idd}/newarrival', 'Admin\ProductsController@newarrival')->name('admin.products.newarrival');

			Route::get('/{id}/{idd}/preorder', 'Admin\ProductsController@preorder')->name('admin.products.preorder');
			Route::get('/{id}/{idd}/stock', 'Admin\ProductsController@stock')->name('admin.products.stock');
			Route::get('/{id}/addsize', 'Admin\ProductsController@addsize')->name('admin.products.addsize');
			Route::post('/addsize', 'Admin\ProductsController@addsizestore')->name('admin.products.addsizestore');
			Route::get('/{id}/editsize', 'Admin\ProductsController@sizeedit')->name('admin.products.editsize');
			Route::post('/updatesize', 'Admin\ProductsController@updatesize')->name('admin.products.updatesize');

			Route::get('/sizelist/{id}', 'Admin\ProductsController@sizelist')->name('admin.products.sizelist');
			Route::get('/sizeDelete/{id}', 'Admin\ProductsController@sizeDelete')->name('admin.products.sizeDelete');
		});

		Route::group(['prefix'  =>   'brands'], function() {
			Route::get('/', 'Admin\BrandController@index')->name('admin.brand.index');
			Route::get('/create', 'Admin\BrandController@create')->name('admin.brand.create');
			Route::post('/store', 'Admin\BrandController@store')->name('admin.brand.store');
			Route::get('/{id}/edit', 'Admin\BrandController@edit')->name('admin.brand.edit');
			Route::post('/update', 'Admin\BrandController@update')->name('admin.brand.update');
			Route::get('/{id}/delete', 'Admin\BrandController@delete')->name('admin.brand.delete');
			Route::post('updateStatus', 'Admin\BrandController@updateStatus')->name('admin.brand.updateStatus');
		});

		Route::group(['prefix'  =>   'testimonial'], function() {
			Route::get('/', 'Admin\TestimonialController@index')->name('admin.testimonial.index');
			Route::get('/create', 'Admin\TestimonialController@create')->name('admin.testimonial.create');
			Route::post('/store', 'Admin\TestimonialController@store')->name('admin.testimonial.store');
			Route::get('/{id}/edit', 'Admin\TestimonialController@edit')->name('admin.testimonial.edit');
			Route::post('/update', 'Admin\TestimonialController@update')->name('admin.testimonial.update');
			Route::get('/{id}/delete', 'Admin\TestimonialController@delete')->name('admin.testimonial.delete');
			Route::post('updateStatus', 'Admin\TestimonialController@updateStatus')->name('admin.testimonial.updateStatus');
		});

		Route::group(['prefix'  =>   'blog'], function() {
			Route::get('/', 'Admin\BlogController@index')->name('admin.blog.index');
			Route::get('/create', 'Admin\BlogController@create')->name('admin.blog.create');
			Route::post('/store', 'Admin\BlogController@store')->name('admin.blog.store');
			Route::get('/{id}/edit', 'Admin\BlogController@edit')->name('admin.blog.edit');
			Route::post('/update', 'Admin\BlogController@update')->name('admin.blog.update');
			Route::get('/{id}/delete', 'Admin\BlogController@delete')->name('admin.blog.delete');
			Route::post('updateStatus', 'Admin\BlogController@updateStatus')->name('admin.blog.updateStatus');
		});

		Route::group(['prefix'  =>   'quiz'], function() {
			Route::get('/', 'Admin\QuizController@index')->name('admin.quiz.index');
			Route::get('/create', 'Admin\QuizController@create')->name('admin.quiz.create');
			Route::post('/store', 'Admin\QuizController@store')->name('admin.quiz.store');
			Route::get('/{id}/edit', 'Admin\QuizController@edit')->name('admin.quiz.edit');
			Route::post('/update', 'Admin\QuizController@update')->name('admin.quiz.update');
			Route::get('/{id}/delete', 'Admin\QuizController@delete')->name('admin.quiz.delete');
			Route::post('updateStatus', 'Admin\QuizController@updateStatus')->name('admin.quiz.updateStatus');
		});
		
		Route::group(['prefix'  =>   'banner'], function() {
			Route::get('/', 'Admin\BannerController@index')->name('admin.banner.index');
			Route::get('/create', 'Admin\BannerController@create')->name('admin.banner.create');
			Route::post('/store', 'Admin\BannerController@store')->name('admin.banner.store');
			Route::get('/{id}/edit', 'Admin\BannerController@edit')->name('admin.banner.edit');
			Route::post('/update', 'Admin\BannerController@update')->name('admin.banner.update');
			Route::get('/{id}/delete', 'Admin\BannerController@delete')->name('admin.banner.delete');
			Route::post('updateStatus', 'Admin\BannerController@updateStatus')->name('admin.banner.updateStatus');
		});

		Route::group(['prefix'  => 'couriers'], function() {
			Route::get('/', 'Admin\CourierController@index')->name('admin.couriers.index');
			Route::get('/create', 'Admin\CourierController@create')->name('admin.couriers.create');
			Route::post('/store', 'Admin\CourierController@store')->name('admin.couriers.store');
			Route::get('/{id}/edit', 'Admin\CourierController@edit')->name('admin.couriers.edit');
			Route::post('/update', 'Admin\CourierController@update')->name('admin.couriers.update');
			Route::get('/{id}/delete', 'Admin\CourierController@delete')->name('admin.couriers.delete');
			Route::post('updateStatus', 'Admin\CourierController@updateStatus')->name('admin.couriers.updateStatus');
		});

		Route::group(['prefix'  => 'couponcodes'], function() {
			Route::get('/', 'Admin\CouponCodeController@index')->name('admin.couponcode.index');
			Route::get('/create', 'Admin\CouponCodeController@create')->name('admin.couponcode.create');
			Route::post('/store', 'Admin\CouponCodeController@store')->name('admin.couponcode.store');
			Route::get('/{id}/edit', 'Admin\CouponCodeController@edit')->name('admin.couponcode.edit');
			Route::post('/update', 'Admin\CouponCodeController@update')->name('admin.couponcode.update');
			Route::get('/{id}/delete', 'Admin\CouponCodeController@delete')->name('admin.couponcode.delete');
			Route::post('updateStatus', 'Admin\CouponCodeController@updateStatus')->name('admin.couponcode.updateStatus');
		});

		Route::group(['prefix'  => 'keyconcept'], function() {
			Route::get('/', 'Admin\KeyconceptController@index')->name('admin.keyconcept.index');
			Route::get('/create', 'Admin\KeyconceptController@create')->name('admin.keyconcept.create');
			Route::post('/store', 'Admin\KeyconceptController@store')->name('admin.keyconcept.store');
			Route::get('/{id}/edit', 'Admin\KeyconceptController@edit')->name('admin.keyconcept.edit');
			Route::post('/update', 'Admin\KeyconceptController@update')->name('admin.keyconcept.update');
			Route::get('/{id}/delete', 'Admin\KeyconceptController@delete')->name('admin.keyconcept.delete');
			Route::post('updateStatus', 'Admin\KeyconceptController@updateStatus')->name('admin.keyconcept.updateStatus');
		});
		
		Route::group(['prefix'  =>   'show'], function() {
			Route::get('/', 'Admin\ShowController@index')->name('admin.show.index');
			Route::get('/create', 'Admin\ShowController@create')->name('admin.show.create');
			Route::post('/store', 'Admin\ShowController@store')->name('admin.show.store');
			Route::get('/{id}/edit', 'Admin\ShowController@edit')->name('admin.show.edit');
			Route::post('/update', 'Admin\ShowController@update')->name('admin.show.update');
			Route::get('/{id}/delete', 'Admin\ShowController@delete')->name('admin.show.delete');
			Route::post('updateStatus', 'Admin\ShowController@updateStatus')->name('admin.show.updateStatus');
			Route::get('/pay-per-click-subscriptions', 'Admin\ShowController@getPayPerClickSubscriptions')->name('admin.show.getPayPerClickSubscriptions');
			Route::get('/transaction-list', 'Admin\ShowController@getTransactionsData')->name('admin.show.getTransactionsData');
		});

		Route::group(['prefix'  =>   'questionpaper'], function() {
			Route::get('/', 'Admin\QuestionpaperController@index')->name('admin.questionpaper.index');
			Route::get('/create', 'Admin\QuestionpaperController@create')->name('admin.questionpaper.create');
			Route::post('/store', 'Admin\QuestionpaperController@store')->name('admin.questionpaper.store');
			Route::get('/{id}/edit', 'Admin\QuestionpaperController@edit')->name('admin.questionpaper.edit');
			Route::post('/update', 'Admin\QuestionpaperController@update')->name('admin.questionpaper.update');
			Route::get('/{id}/delete', 'Admin\QuestionpaperController@delete')->name('admin.questionpaper.delete');
			Route::post('updateStatus', 'Admin\QuestionpaperController@updateStatus')->name('admin.questionpaper.updateStatus');
		});
		
		Route::group(['prefix'  =>   'packages'], function() {
			Route::get('/', 'Admin\PackageController@index')->name('admin.packages.index');
			Route::get('/create', 'Admin\PackageController@create')->name('admin.packages.create');
			Route::post('/store', 'Admin\PackageController@store')->name('admin.packages.store');
			Route::get('/{id}/edit', 'Admin\PackageController@edit')->name('admin.packages.edit');
			Route::post('/update', 'Admin\PackageController@update')->name('admin.packages.update');
			Route::get('/{id}/delete', 'Admin\PackageController@delete')->name('admin.packages.delete');
			Route::post('/updateStatus', 'Admin\PackageController@updateStatus')->name('admin.packages.updateStatus');
			Route::get('/all-subscriptions', 'Admin\PackageController@getSubscriptions')->name('admin.packages.getSubscriptions');
		});

		Route::group(['prefix'  =>   'orders'], function() {
			Route::get('/', 'Admin\OrderController@index')->name('admin.orders.index');
			Route::get('/{id}/view', 'Admin\OrderController@viewDetail')->name('admin.orders.detail');
			Route::get('/{id}/delete', 'Admin\OrderController@delete')->name('admin.orders.delete');
			Route::post('/updatecourier/{id}', 'Admin\OrderController@updatecourier')->name('admin.orders.updatecourier');
			Route::get('/{id}/invoice', 'Admin\OrderController@invoice')->name('admin.orders.invoice');
			Route::get('/{id}/makepdf', 'Admin\OrderController@makepdf')->name('admin.orders.makepdf');
		});

		// Users
		Route::group(['prefix'  =>   'users'], function() {
			Route::get('/', 'Admin\UserManagementController@index')->name('admin.users.index');
			Route::get('/create', 'Admin\UserManagementController@create')->name('admin.users.create');
			Route::post('/store', 'Admin\UserManagementController@store')->name('admin.users.store');
			Route::get('/{id}/edit', 'Admin\UserManagementController@edit')->name('admin.users.edit');
			Route::post('/update', 'Admin\UserManagementController@update')->name('admin.users.update');
			Route::get('/{id}/delete', 'Admin\UserManagementController@delete')->name('admin.users.delete');
			Route::get('/{id}/view', 'Admin\UserManagementController@viewDetail')->name('admin.users.detail');
			Route::post('updateStatus', 'Admin\UserManagementController@updateStatus')->name('admin.users.updateStatus');
		});

		// Teachers
		Route::group(['prefix'  =>   'teacher'], function() {
			Route::get('/', 'Admin\TeacherManagementController@index')->name('admin.teacher.index');
			Route::get('/crate', 'Admin\TeacherManagementController@create')->name('admin.teacher.create');
			Route::post('/crate', 'Admin\TeacherManagementController@saveTeacher')->name('admin.teacher.store');
			Route::get('/{id}/edit', 'Admin\TeacherManagementController@editTeacher')->name('admin.teacher.edit');
			Route::post('/{id}/update', 'Admin\TeacherManagementController@updateTeacher')->name('admin.teacher.update');
			Route::get('/{id}/delete', 'Admin\TeacherManagementController@deleteTeacher')->name('admin.teacher.delete');
		});

		// Course
		Route::group(['prefix' => 'course'],function(){
			Route::get('/','Admin\CourseManagementController@index')->name('admin.course');
			Route::get('/create','Admin\CourseManagementController@createCourse')->name('admin.course.create');
			Route::post('/create','Admin\CourseManagementController@saveCourse')->name('admin.course.store');
			Route::get('/edit/{id}','Admin\CourseManagementController@editCourse')->name('admin.course.edit');
			Route::post('/update/{id}','Admin\CourseManagementController@updateCourse')->name('admin.course.update');
			Route::post('/delete','Admin\CourseManagementController@deleteCourse')->name('admin.course.delete');

			// Lectures
			Route::group(['prefix' => 'lecture'],function(){
				Route::get('/{courseId}','Admin\CourseManagementController@lectures')->name('admin.course.lecture');
				Route::post('save/{courseId}','Admin\CourseManagementController@saveLecture')->name('admin.course.lecture.save');
				Route::post('update/{courseId}','Admin\CourseManagementController@updateLecture')->name('admin.course.lecture.update');
				Route::post('/delete','Admin\CourseManagementController@deleteLectures')->name('admin.course.lecture.delete');
			});

			// Features
			Route::group(['prefix' => 'feature'],function(){
				Route::get('/{courseId}','Admin\CourseManagementController@features')->name('admin.course.feature');
				Route::post('save/{courseId}','Admin\CourseManagementController@saveFeature')->name('admin.feature.save');
				Route::post('update/{courseId}','Admin\CourseManagementController@updateFeature')->name('admin.feature.update');
				Route::post('/delete','Admin\CourseManagementController@deleteFeatures')->name('admin.course.feature.delete');
			});
		});

		// Zoom Meetings
		Route::group(['prefix' => 'zoom'],function(){
			Route::get('meeting','Admin\ZoomController@index')->name('admin.zoom.index');
			Route::get('meeting/create','Admin\ZoomController@createMeeting')->name('admin.zoom.create');
			Route::post('meeting/create','Admin\ZoomController@saveMeeting')->name('admin.zoom.save');
			Route::post('meeting/delete','Admin\ZoomController@deleteZoomMeeting')->name('admin.zoom.delete');
		});

		Route::group(['prefix'=>'contactus'],function(){
			Route::get('/','Admin\SettingController@contact_us')->name('admin.contactus');
			Route::get('/list','Admin\SettingController@contactUsList')->name('admin.contactus.list');
			Route::post('/save','Admin\SettingController@saveContactUs')->name('admin.contact.save');
		});

		//question module - categories
		Route::group(['prefix'  =>   'categories'], function() {
			Route::get('/', 'Admin\CategoryController@index')->name('admin.category.index');
			Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('admin.category.edit');
			Route::post('/update', 'Admin\CategoryController@update')->name('admin.category.update');
		});
		
		//question module - subject categories
		Route::group(['prefix'  =>   'subject/categories'], function() {
			Route::get('/{categoryId?}', 'Admin\SubjectCategoryController@index')->name('admin.subject.category.index');
			Route::get('/create/new', 'Admin\SubjectCategoryController@create')->name('admin.subject.category.create');
			Route::post('/new/store', 'Admin\SubjectCategoryController@store')->name('admin.subject.category.store');
			Route::get('/{id}/edit', 'Admin\SubjectCategoryController@edit')->name('admin.subject.category.edit');
			Route::post('/old/update', 'Admin\SubjectCategoryController@update')->name('admin.subject.category.update');
			Route::get('/{id}/delete', 'Admin\SubjectCategoryController@delete')->name('admin.subject.category.delete');
			Route::post('/get-subject-categories-data', 'Admin\SubjectCategoryController@getCategoryData')->name('get.subject.categories.data');
		});
		
		//question module - chapters
		Route::group(['prefix'  =>   'chapters'], function() {
			Route::get('/', 'Admin\ChaptersController@index')->name('admin.chapters.index');
			Route::get('/create', 'Admin\ChaptersController@create')->name('admin.chapters.create');
			Route::post('/store', 'Admin\ChaptersController@store')->name('admin.chapters.store');
			Route::get('/{id}/edit', 'Admin\ChaptersController@edit')->name('admin.chapters.edit');
			Route::post('/update', 'Admin\ChaptersController@update')->name('admin.chapters.update');
			Route::get('/{id}/delete', 'Admin\ChaptersController@delete')->name('admin.chapters.delete');
		});

		//question module - subject chapters
		Route::group(['prefix'  =>   'subject-chapters'], function() {
			Route::get('/list/{chapterId?}', 'Admin\SubjectChapterController@index')->name('admin.subject.chapter.index');
			Route::get('/create', 'Admin\SubjectChapterController@create')->name('admin.subject.chapter.create');
			Route::post('/store', 'Admin\SubjectChapterController@store')->name('admin.subject.chapter.store');
			Route::get('/{id}/edit', 'Admin\SubjectChapterController@edit')->name('admin.subject.chapter.edit');
			Route::post('/update', 'Admin\SubjectChapterController@update')->name('admin.subject.chapter.update');
			Route::get('/{id}/delete', 'Admin\SubjectChapterController@delete')->name('admin.subject.chapter.delete');
		});
		
		//question module - questions
		Route::group(['prefix'  =>   'questions'], function() {
			Route::get('/list/{chapterId?}', 'Admin\QuestionController@index')->name('admin.question.index');
			Route::get('/create', 'Admin\QuestionController@create')->name('admin.question.create');
			Route::post('/store', 'Admin\QuestionController@store')->name('admin.question.store');
			Route::get('/{id}/edit', 'Admin\QuestionController@edit')->name('admin.question.edit');
			Route::post('/update', 'Admin\QuestionController@update')->name('admin.question.update');
			Route::get('/{id}/delete', 'Admin\QuestionController@delete')->name('admin.question.delete');
		});
	});
});
?>