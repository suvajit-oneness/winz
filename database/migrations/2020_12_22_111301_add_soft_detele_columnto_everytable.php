<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeteleColumntoEverytable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement("ALTER TABLE `admins` ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `is_deleted`");
        Schema::table('admins', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('banners', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('blogs', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('board', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('bookings', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('booking_products', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('brands', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('carts', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('cities', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('class', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('compares', function($table) {
            $table->softDeletes();
        });
        Schema::table('contacts', function($table) {
            $table->softDeletes();
        });
        Schema::table('countries', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('coupon_codes', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('couriers', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('creditlists', function($table) {
            $table->softDeletes();
        });
        Schema::table('downloads', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('enquiries', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('galleries', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('key_conceptes', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('level5', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('memberships', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('news_letter_subscribers', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('pin_codes', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('plans', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('products', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('productsizes', function($table) {
            $table->softDeletes();
        });
        Schema::table('product_images', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('product_reviews', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('product_stock', function($table) {
            $table->softDeletes();
        });
        Schema::table('product_version_prices', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('questions', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('question_papers', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('quizzes', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('settings', function($table) {
            $table->softDeletes();
        });
        Schema::table('shippingcharge', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('sizes', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('software_prices', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('states', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('subject', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('subtopic', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('testimonials', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('topic', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('tutors', function($table) {
            // $table->dropColumn('is_active');
            $table->softDeletes();
        });
        Schema::table('users', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
        Schema::table('user_shipping', function($table) {
            $table->softDeletes();
        });
        Schema::table('wish_lists', function($table) {
            // $table->dropColumn('is_active');
            $table->dropColumn('is_deleted');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('banners', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('blogs', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('board', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('bookings', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('booking_products', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('brands', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('carts', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('cities', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('class', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('compares', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('contacts', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('countries', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('coupon_codes', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('couriers', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('creditlists', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('downloads', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('enquiries', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('galleries', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('key_conceptes', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('level5', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('memberships', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('news_letter_subscribers', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('pin_codes', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('plans', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('products', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('productsizes', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('product_images', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('product_reviews', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('product_stock', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('product_version_prices', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('questions', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('question_papers', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('quizzes', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('settings', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('shippingcharge', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('sizes', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('software_prices', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('states', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('subject', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('subtopic', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('testimonials', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('topic', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('tutors', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->dropColumn('deleted_at');
        });
        Schema::table('users', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
        Schema::table('user_shipping', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('wish_lists', function($table) {
            // $table->tinyInteger('is_active')->comment('1=active')->default(1);
            $table->tinyInteger('is_deleted')->comment('1=deleted')->default(0);
            $table->dropColumn('deleted_at');
        });
    }
}
