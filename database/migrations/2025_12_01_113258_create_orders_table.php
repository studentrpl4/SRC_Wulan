<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained()->onDelete('cascade');
        $table->string('invoice')->unique();  // contoh: INV-20250101-XYZ
        $table->string('address');
        $table->string('payment_method');
        $table->integer('total_price');
        $table->string('status')->default('processing'); // processing, shipped, completed
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('orders');
}
};
