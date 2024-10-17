<?php

// import untuk class-class yang diperlukan.
// Migration: class yang digunakan untuk membuat perubahan struktur database.
// Blueprint: digunakan untuk mendefinisikan kolom dan properti dalam tabel.
// Schema: digunakan untuk membuat, mengubah, dan menghapus tabel dalam database.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // berisi perubahan yang akan dilakukan pada tabel users.
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // kolom baru dengan tipe enum (enumerasi) ditambahkan ke tabel users. Kolom ini bernama role dengan dua kemungkinan nilai: admin atau user.
            $table->enum('role', ['admin', 'user']);
        });
    }

    /**
     * Reverse the migrations.
     */

     //kebalikan dari up(), digunakan untuk membatalkan perubahan yang dilakukan oleh migration.
     //menghapus kolom yang ditambahkan di method up()
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user']);
        });
    }
};