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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_code');
            $table->foreign('vendor_code')->on('vendors')->references('code');
            $table->string('description', 200)->nullable();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
