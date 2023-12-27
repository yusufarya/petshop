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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->char('customer_code');
            $table->foreign('customer_code')->on('customers')->references('code');
            $table->unsignedBigInteger('size_id');
            $table->char('service_id');
            $table->foreign('service_id')->on('customers')->references('id');
            $table->dateTime('date')->nullable();
            $table->string('description', 200);
            $table->double('qty')->default(0);
            $table->double('price')->default(0);
            $table->double('charge')->default(0);
            $table->double('nett')->default(0);
            $table->text('image')->nullable();
            $table->enum('status', ['Y', 'N'])->default('N'); // Y terjual N masih dalam pesanan
            // 0 pesanan 1 persiapan 2 pengiriman 3 selesai / pesanan sampai tujuan 4 acc_order
            $table->enum('delivery', ['0','1', '2', '3', '4'])->default('0'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
