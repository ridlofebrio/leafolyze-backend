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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('public_id');
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_details_id')->constrained('user_details')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tomato_leaf_detections_id')->constrained('tomato_leaf_detections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('shops_id')->constrained('shops')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image');
    }
};
