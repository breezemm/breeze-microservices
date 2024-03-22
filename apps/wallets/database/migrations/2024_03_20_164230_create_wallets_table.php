<?php

use App\Enums\CurrencyType;
use App\Enums\WalletType;
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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('qr_code')->unique();
            $table->string('name');
            $table->decimal('balance', 64)->default(0);
            $table->json('meta')->nullable();
            $table->string('currency')->default(CurrencyType::MMK);
            $table->string('user_id');
            $table->string('type')->default(WalletType::PREPAID);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
