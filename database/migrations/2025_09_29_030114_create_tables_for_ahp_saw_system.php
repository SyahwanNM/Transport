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
        // 1. Buat tabel kota terlebih dahulu
        Schema::create('kota', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kota');
            $table->decimal('umr', 15, 2); // Upah Minimum Regional
            $table->decimal('waktu_tempuh', 8, 2); // Waktu tempuh rata-rata (detik per km)
            $table->integer('jumlah_armada'); // Jumlah armada ojol
            $table->integer('jumlah_kendaraan_pribadi'); // Jumlah kendaraan pribadi
            $table->decimal('tarif_minimum_aktual', 10, 2)->nullable(); // Tarif minimum aktual dari input user
            $table->timestamps();
        });

        // 2. Buat tabel kriteria
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria', 10); // C1, C2, C3, C4
            $table->string('nama_kriteria');
            $table->enum('jenis', ['benefit', 'cost']); // Benefit = semakin besar semakin baik, Cost = semakin kecil semakin baik
            $table->timestamps();
        });

        // 3. Buat tabel bobot
        Schema::create('bobot', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria', 10);
            $table->decimal('bobot', 5, 4); // Bobot AHP (0.0000 - 1.0000)
            $table->timestamps();
        });

        // 4. Buat tabel hasil perhitungan
        Schema::create('hasil_perhitungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kota_id')->constrained('kota');
            $table->string('kode_kriteria', 10);
            $table->decimal('nilai_normalisasi', 8, 6); // Nilai normalisasi SAW
            $table->decimal('skor_preferensi', 8, 6); // Skor preferensi akhir (Vi)
            $table->timestamps();
        });

        // 5. Buat tabel tarif rekomendasi
        Schema::create('tarif_rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kota_acuan_id')->constrained('kota'); // Kota yang dijadikan acuan
            $table->foreignId('kota_banding_id')->constrained('kota'); // Kota yang dibandingkan
            $table->decimal('tarif_acuan', 10, 2); // Tarif minimum kota acuan
            $table->decimal('skor_acuan', 8, 6); // Skor preferensi kota acuan
            $table->decimal('skor_banding', 8, 6); // Skor preferensi kota banding
            $table->decimal('tarif_rekomendasi', 10, 2); // Tarif rekomendasi hasil perhitungan
            $table->decimal('tarif_aktual', 10, 2)->nullable(); // Tarif aktual dari input user
            $table->decimal('selisih', 10, 2)->nullable(); // Selisih antara rekomendasi dan aktual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_rekomendasi');
        Schema::dropIfExists('hasil_perhitungan');
        Schema::dropIfExists('bobot');
        Schema::dropIfExists('kriteria');
        Schema::dropIfExists('kota');
    }
};
