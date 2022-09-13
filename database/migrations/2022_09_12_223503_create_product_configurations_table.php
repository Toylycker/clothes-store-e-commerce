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
        Schema::create('product_configurations', function (Blueprint $table) {
            $table->unsignedBigInteger('va_op_id')->index();
            $table->foreign('va_op_id')->references('id')->on('variation_options')->cascadeOnDelete();
            $table->unsignedBigInteger('ou_it_id')->index();
            $table->foreign('ou_it_id')->references('id')->on('outfit_items')->cascadeOnDelete();
            $table->primary(['va_op_id', 'ou_it_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_configurations');
    }
};
