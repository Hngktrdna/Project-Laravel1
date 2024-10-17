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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines'); // This should be correct
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
               
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
