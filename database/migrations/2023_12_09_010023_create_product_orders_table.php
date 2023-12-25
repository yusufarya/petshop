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
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->char('customer_code');
            $table->foreign('customer_code')->on('customers')->references('code');
            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->on('sizes')->references('id');
            $table->dateTime('date')->nullable()->default(date('Y-m-d H:i:s'));
            $table->string('description', 200);
            $table->double('qty')->default(0);
            $table->double('price')->default(0);
            $table->text('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
