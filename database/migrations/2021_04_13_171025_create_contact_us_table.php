<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->comment('1:Setting,2:Visitors Contact')->default(2);
            $table->string('name');
            $table->string('email');
            $table->string('mobile',20);
            $table->string('subject');
            $table->longText('message');
            $table->string('address');
            $table->bigInteger('claimedBy')->comment('userId from users Table');
            $table->string('remarks');
            $table->string('media');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            [
                'type' => 1,
                'address' => '4967 Sardis Sta, Victoria 8007, Montreal.',
                'mobile' => '+1 246-345-0695',
                'email' => 'info@test.com',
            ],
        ];
        DB::table('contact_us')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us');
    }
}
