<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id'); 
            $table->foreign('message_id')
                ->references('id')->on('messages')->onDelete('cascade')->coment('message_id');
            $table->text('response')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 = unread - 1 = read ');
            $table->tinyInteger('sender_type')->nullable();
            $table->text('sender_id')->nullable();
            $table->tinyInteger('receiver_type')->nullable();
            $table->json('receiver_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages_responses');
    }
};
