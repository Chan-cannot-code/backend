<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->integer('quantity');
            $table->string('name');
            $table->string('image');
            $table->string('description');
            $table->integer('price');
            $table->string('category');
            $table->timestamps(); // This line adds 'created_at' and 'updated_at' columns
        });

        // constraints
        Schema::table('products', function (Blueprint $table) {
            $table->string('school_id')->references('school_id')->on('login_credentials')->onDelete('cascade');
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
