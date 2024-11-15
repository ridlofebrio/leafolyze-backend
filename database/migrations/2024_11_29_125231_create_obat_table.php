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
            $table->string('gambarUrl');
            $table->string('name');
            $table->foreignId('shop_id')->nullable()->constrained('shops')->onDelete('cascade');
            $table->text('description');
            $table->string('price');
            $table->enum('type' , ['Bacterial Spot', 'Early Blight','Healthy','Late Blight','Leaf Mold','Target Spot','Black Spot']);
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
