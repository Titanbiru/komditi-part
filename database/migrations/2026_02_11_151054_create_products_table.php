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
            $table->foreign('category_id')->nullable()->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('is_promo')->default(false);
            $table->integer('sold')->default(0);
            $table->decimal('weight', 8, 2)->nullable(); // weight in grams
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
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
