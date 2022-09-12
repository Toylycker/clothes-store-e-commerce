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
        Schema::create('outfit_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outfit_id')->index();
            $table->foreign('outfit_id')->references('id')->on('outfits')->cascadeOnDelete();
            $table->unsignedFloat('price')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->dateTime('discount_datetime_start')->useCurrent();
            $table->dateTime('discount_datetime_end')->useCurrent();
            $table->boolean('credit')->default(0);
            $table->unsignedInteger('sold')->default(0);
            $table->boolean('purchase_way')->default(0);//stock>0?w nalichi:na zakaz;
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
        Schema::dropIfExists('outfit_items');
    }
};
