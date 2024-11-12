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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('gambarUrlObat');
            $table->string('namaObat');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('deskripsi');
            $table->string('harga');
            $table->enum('jenis' , ['Bacterial Spot', 'Early Blight','Healthy','Late Blight','Leaf Mold','Target Spot','Black Spot']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
