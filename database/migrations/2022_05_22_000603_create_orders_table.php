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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('outfit_item_id');
            $table->foreign('outfit_item_id')->references('id')->on('outfit_items')->cascadeOnDelete();
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->cascadeOnDelete();
            $table->text('from_location')->nullable();
            $table->text('to_location')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->string('order_num')->unique();
            $table->string('receiver_phone');
            $table->string('sender_phone');
            $table->boolean('online_pay_done')->nullable();
            $table->string('language')->nullable();//language using which customer made the order to choose right email on right language to send him
            $table->boolean('has_mail')->nullable();//does customer have mail
            $table->boolean('sms_sent')->nullable();
            $table->boolean('mail_sent')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('disabled')->nullable(); // in case of customer deleting the order, it should be disabled true and not seen to customer but show up on statistics.
            $table->unsignedBigInteger('delivery_fee')->nullable();
            $table->integer('price');
            $table->integer('quantity');
            $table->string('order_status');//paid->accepted->sent->received
            //one order has many delivery proccesess(accepted from delivery company->sent->on its way->delivered)
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
