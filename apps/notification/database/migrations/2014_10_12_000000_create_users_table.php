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
            $table->id();
            $table->string('user_id')->unique(); // The ID of the user in your system. Required.
            $table->string('email')->unique()->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->json('push_tokens')->nullable();
            $table->json('web_push_tokens')->nullable();
            $table->json('settings');
            $table->timestamps();

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
