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
        Schema::create('gift_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_purchase');
            $table->enum('gift_type', ['physical', 'promo']);
            $table->foreignId('promo_id')->nullable()->constrained('promo_codes')->nullOnDelete();
            $table->string('gift_name')->nullable();        // untuk hadiah fisik
            $table->text('gift_description')->nullable();
            $table->integer('duration_days');               // berapa hari event berlangsung
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_events');
    }
};
