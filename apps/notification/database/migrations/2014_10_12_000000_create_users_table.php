<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        MongoDB\Laravel\Schema\Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique();
            $table->json('notification_settings');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->json('push_tokens');
            $table->json('web_push_tokens');

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
