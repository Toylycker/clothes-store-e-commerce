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
        Schema::create('outfits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->index();
            $table->foreign('seller_id')->references('id')->on('sellers')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('name_en');
            $table->string('slug')->index()->nullable;
            $table->unsignedInteger('viewed')->default(0);
            $table->boolean('recommended')->default(0);
            $table->unsignedInteger('liked')->default(0);
            $table->string('image')->nullable();
            $table->string('search')->nullable();// all relations name for quick search by one query
            $table->timestamps();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->unsignedFloat('price')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->dateTime('discount_datetime_start')->useCurrent();
            $table->dateTime('discount_datetime_end')->useCurrent();
            $table->boolean('credit')->default(0);
            $table->unsignedInteger('sold')->default(0);
            $table->boolean('purchase_way')->default(0);//stock>0?w nalichi:na zakaz;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outfits');
    }
};
