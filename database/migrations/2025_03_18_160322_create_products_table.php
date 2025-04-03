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
            $table->string('product_name');
            $table->string('product_image');
            $table->string('CPU');
            $table->string('RAM');
            $table->string('storage');
            $table->string('VGA');
            $table->string('SCREEN');
            $table->decimal('product_rating', 3, 1)->default(0.0);
            $table->decimal('product_price', 10, 2);
            $table->string('OS');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('label_id')->nullable()->constrained('labels')->onDelete('cascade');
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
