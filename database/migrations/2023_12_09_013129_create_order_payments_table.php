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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->char('order_code');
            $table->dateTime('date')->nullable();
            $table->enum('status', ['Approve', 'Reject', 'Waiting'])->default('Waiting');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->on('payment_methods')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
