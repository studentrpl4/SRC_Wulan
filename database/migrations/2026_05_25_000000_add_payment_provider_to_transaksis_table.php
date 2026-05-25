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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('payment_provider')->default('midtrans')->after('snap_token');
            $table->string('external_reference_id')->nullable()->after('payment_provider');
        });

        // Backfill existing rows to 'midtrans' in case default not applied by DB
        try {
            \DB::table('transaksis')->whereNull('payment_provider')->update(['payment_provider' => 'midtrans']);
        } catch (\Throwable $e) {
            // Ignore if table does not exist in early bootstrap
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('external_reference_id');
            $table->dropColumn('payment_provider');
        });
    }
};
