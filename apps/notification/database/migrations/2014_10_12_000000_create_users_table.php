<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void
    {


        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id')->unique(); // The ID of the user in your system. Required.
            $table->json('notification_settings');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->json('push_tokens');
            $table->json('web_push_tokens');
            $table->json('settings');

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
