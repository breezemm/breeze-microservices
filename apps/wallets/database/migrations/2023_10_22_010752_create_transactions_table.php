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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignId('sender_user_id');
            $table->foreignId('receiver_user_id');

            $table->string('transaction_type');

            $table->string('transaction_amount');
            $table->string('transaction_currency')->default('MMK');
            $table->string('transaction_description')->nullable();

            $table->string('sender_wallet_id');
            $table->string('receiver_wallet_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
