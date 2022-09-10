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
        Schema::create('outfit_values', function (Blueprint $table) {
            $table->unsignedBigInteger('outfit_id');
            $table->foreign('outfit_id')->references('id')->on('outfits')->cascadeOnDelete();
            $table->unsignedBigInteger('value_id');
            $table->foreign('value_id')->references('id')->on('values')->cascadeOnDelete();
            $table->primary(['outfit_id', 'value_id']);
            $table->Integer('sort_order')->nullable();
            $table->Integer('quantity')->default(1);//quantity of product that seller has.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outfit_values');
    }
};
