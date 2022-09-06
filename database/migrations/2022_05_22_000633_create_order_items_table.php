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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->unsignedBigInteger('outfit_id');
            $table->foreign('outfit_id')->references('id')->on('outfits')->cascadeOnDelete();
            $table->unsignedBigInteger('age_id');
            $table->foreign('age_id')->references('id')->on('ages');
            $table->unsignedBigInteger('delivery_process_id')->nullable();
            $table->foreign('delivery_process_id')->references('id')->on('delivery_processes');
            $table->integer('quantity');
            $table->integer('price')->default(0);
            $table->integer('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
