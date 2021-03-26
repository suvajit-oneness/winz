<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transactionId');
            $table->string('balance_transaction');
            $table->float('amount',8,2);
            $table->longText('description');
            $table->string('payment_method');
            $table->string('card_type',20);
            $table->string('exp_month',5);
            $table->string('exp_year',6);
            $table->string('last4');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_transactions');
    }
}
