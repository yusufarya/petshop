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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->char('customer_code');
            $table->foreign('customer_code')->on('customers')->references('code');
            $table->string('description', 200);
            $table->dateTime('date')->nullable()->default(date('Y-m-d H:i:s'));
            $table->double('qty')->default(0);
            $table->double('total_price')->default(0);
            $table->double('discount')->default(0);
            $table->double('charge')->default(0);
            $table->double('nett')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
