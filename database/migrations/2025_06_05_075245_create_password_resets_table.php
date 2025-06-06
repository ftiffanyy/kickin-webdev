<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id(); // Primary key ID untuk tabel ini
            $table->string('email'); // Kolom email untuk referensi pengguna
            $table->string('token'); // Token untuk reset password
            $table->timestamp('created_at')->useCurrent(); // Waktu pembuatan token

            // Menambahkan indeks untuk mempercepat pencarian berdasarkan email
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade'); // Relasi ke tabel 'users' (opsional, jika menggunakan email sebagai penghubung)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets'); // Menghapus tabel password_resets jika rollback dilakukan
    }
}
