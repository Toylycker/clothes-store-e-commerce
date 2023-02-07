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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('chats')->cascadeOnDelete();
            $table->unsignedBigInteger('outfit_id')->nullable();
            $table->foreign('outfit_id')->references('id')->on('outfits')->cascadeOnDelete();
            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('to_id')->nullable();
            $table->foreign('to_id')->references('id')->on('users')->cascadeOnDelete();
            $table->mediumText('content');
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('messages');
    }
};