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
        Schema::create('point_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('rupiah_per_point')->default(10000); // Rp 10rb = 1 poin
            $table->integer('points_per_reward')->default(100);  // 100 poin bisa ditukar
            $table->integer('reward_value')->default(10000);     // nilainya Rp 10rb
            $table->integer('expired_months')->default(6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_settings');
    }
};
