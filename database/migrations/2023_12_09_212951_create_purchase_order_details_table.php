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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            // $table->id();
            $table->char('purchase_order_code');
            $table->foreign('purchase_order_code')->on('purchase_orders')->references('code');
            $table->integer('sequence');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->on('products')->references('id');
            $table->dateTime('date')->nullable();
            $table->double('qty')->default(0);
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->double('charge')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
