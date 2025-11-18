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
        Schema::create('history_penggunaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kota_user'); // Nama kota yang diinput user
            $table->decimal('umr_user', 15, 2);
            $table->decimal('waktu_tempuh_user', 8, 2);
            $table->integer('jumlah_armada_user');
            $table->integer('jumlah_kendaraan_pribadi_user');
            $table->decimal('tarif_minimum_aktual_user', 10, 2);
            $table->foreignId('kota_pembanding_id')->constrained('kota'); // Kota yang digunakan sebagai pembanding
            $table->decimal('tarif_rekomendasi', 10, 2);
            $table->decimal('selisih', 10, 2)->nullable();
            $table->decimal('skor_user', 8, 6);
            $table->decimal('skor_pembanding', 8, 6);
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_penggunaan');
    }
};
