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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uuid');
            $table->morphs('holder');
            $table->string('slug');
            $table->decimal('balance', 64, 0)
                ->default(0);
            $table->json('meta')
                ->nullable();

            $table->unique(['holder_id', 'holder_type', 'slug', 'uuid']);

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
