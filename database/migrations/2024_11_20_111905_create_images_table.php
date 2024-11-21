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
            $table->enum('type', ['article', 'user_detail', 'tomato_leaf_detection', 'shop', 'product']);
            $table->unsignedBigInteger('article_id')->nullable();
            $table->unsignedBigInteger('user_detail_id')->nullable();
            $table->unsignedBigInteger('tomato_leaf_detection_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->timestamps();

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_detail_id')
                ->references('id')
                ->on('user_details')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tomato_leaf_detection_id')
                ->references('id')
                ->on('tomato_leaf_detections')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropForeign(['user_detail_id']);
            $table->dropForeign(['tomato_leaf_detection_id']);
            $table->dropForeign(['shop_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('image');
    }
};