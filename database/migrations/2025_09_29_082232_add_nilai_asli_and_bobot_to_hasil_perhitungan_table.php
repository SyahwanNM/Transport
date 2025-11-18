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
        Schema::table('hasil_perhitungan', function (Blueprint $table) {
            $table->decimal('nilai_asli', 10, 2)->nullable()->after('kode_kriteria');
            $table->decimal('bobot', 5, 4)->nullable()->after('nilai_asli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_perhitungan', function (Blueprint $table) {
            $table->dropColumn(['nilai_asli', 'bobot']);
        });
    }
};
