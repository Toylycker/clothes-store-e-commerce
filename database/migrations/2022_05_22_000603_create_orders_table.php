<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->integer('order_num')->unique();
            $table->string('phone');
            $table->boolean('online_pay_done')->nullable();
            $table->string('language')->nullable();//language using which customer made the order to choose right email on right language to send him
            $table->boolean('has_mail')->nullable();//does customer have mail
            $table->boolean('sms_sent')->nullable();
            $table->boolean('mail_sent')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('disabled')->nullable(); // in case of customer deleting the order, it should be disabled true and not seen to customer but show up on statistics.
            $table->unsignedBigInteger('outfits_total_amount')->nullable();
            $table->unsignedBigInteger('delivery_fee')->nullable();
            $table->unsignedBigInteger('order_total_amount')->nullable();// = outfits_total_amount + delivery_fee
            $table->string('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
