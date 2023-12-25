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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('categories')->references('id');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->on('units')->references('id');
            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->on('sizes')->references('id'); 
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->double('purchase_price')->default(0);;
            $table->double('selling_price')->default(0);;
            $table->enum('is_active', ['Y','N'])->default('Y');
            $table->text('image')->nullable();
            $table->dateTime('created_at')->nullable()->default(date('Y-m-d H:i:s'));
            $table->string('created_by', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('updated_by', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
