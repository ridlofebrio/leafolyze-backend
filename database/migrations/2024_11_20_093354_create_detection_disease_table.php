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
        Schema::create('detection_disease', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detection_id')->constrained('tomato_leaf_detections')->onDelete('cascade');
            $table->foreignId('disease_id')->constrained('diseases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detection_disease');
    }
};
