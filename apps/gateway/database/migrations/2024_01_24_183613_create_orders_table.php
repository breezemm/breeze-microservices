<?php

use App\Enums\BuyerTypeEnum;
use App\Enums\QRCodeStatusEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->index()->constrained('events')->cascadeOnDelete();
            $table->foreignId('ticket_id')->index()->constrained('tickets')->cascadeOnDelete();
            $table->uuid('qr_code')->unique()->index();
            $table->string('qr_code_status')->default(QRCodeStatusEnum::PENDING);

            $table->string('buyer_type')->default(BuyerTypeEnum::USER); // USER, GUEST
            $table->string('guest_invitation_status')->nullable(); // PENDING, ACCEPTED, REJECTED
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
