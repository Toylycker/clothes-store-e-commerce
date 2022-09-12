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
            $table->unsignedBigInteger('variation_option_id')->index();
            $table->foreign('variation_option_id')->references('id')->on('variation_options')->cascadeOnDelete();
            $table->unsignedBigInteger('product_item_id')->index();
            $table->foreign('product_item_id')->references('id')->on('product_items')->cascadeOnDelete();
            $table->primary(['variation_option_id', 'product_item_id']);
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
