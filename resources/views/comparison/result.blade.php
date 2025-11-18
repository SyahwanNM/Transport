@extends('layouts.app')

@section('title', 'Hasil Perbandingan - Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online')

@section('content')
<div class="min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-white">
                Hasil Perbandingan Tarif
            </h1>
            <p class="text-lg sm:text-xl text-gray-400">
                Perbandingan antara <span class="font-semibold text-cyan-400">{{ $result['user_kota']['nama_kota'] }}</span> dengan <span class="font-semibold text-cyan-400">{{ $result['kota_pembanding']['nama_kota'] }}</span>
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
            <a 
                href="{{ route('comparison.index') }}" 
                class="px-6 py-3 bg-slate-800/50 border border-slate-700 text-gray-300 font-semibold rounded-xl hover:bg-slate-700/50 hover:text-white transition-all duration-200 backdrop-blur-sm text-center"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Form
            </a>
            <a 
                href="{{ route('home') }}" 
                class="px-6 py-3 bg-slate-800/50 border border-slate-700 text-gray-300 font-semibold rounded-xl hover:bg-slate-700/50 hover:text-white transition-all duration-200 backdrop-blur-sm text-center"
            >
                <i class="fas fa-home mr-2"></i>
                Beranda
            </a>
        </div>

        <!-- Comparison Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Kota Pembanding Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 border-l-4 border-cyan-500 shadow-xl hover:border-cyan-400 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">{{ $result['kota_pembanding']['nama_kota'] }}</h2>
                    <span class="px-3 py-1 bg-cyan-500/20 text-cyan-400 text-xs font-semibold rounded-full border border-cyan-500/30">
                        Kota Pembanding
                    </span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">UMR</span>
                        <span class="font-semibold text-gray-100">Rp {{ number_format($result['kota_pembanding']['umr'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">Waktu Tempuh</span>
                        <span class="font-semibold text-gray-100">{{ number_format($result['kota_pembanding']['waktu_tempuh'], 0, ',', '.') }} detik/km</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">Jumlah Armada</span>
                        <span class="font-semibold text-gray-100">{{ number_format($result['kota_pembanding']['jumlah_armada'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">Kendaraan Pribadi</span>
                        <span class="font-semibold text-gray-100">{{ number_format($result['kota_pembanding']['jumlah_kendaraan_pribadi'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t-2 border-cyan-500/30">
                        <span class="text-gray-300 font-semibold">Tarif Minimum</span>
                        <span class="font-bold text-cyan-400 text-xl">Rp {{ number_format($result['kota_pembanding']['tarif_minimum_aktual'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-300 font-semibold">Skor Preferensi</span>
                        <span class="font-bold text-cyan-400 text-xl">{{ number_format($result['skor_pembanding'], 4, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- User City Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 border-l-4 border-purple-500 shadow-xl hover:border-purple-400 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">{{ $result['user_kota']['nama_kota'] }}</h2>
                    <span class="px-3 py-1 bg-purple-500/20 text-purple-400 text-xs font-semibold rounded-full border border-purple-500/30">
                        Kota Anda
                    </span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">UMR</span>
                        <span class="font-semibold text-gray-100">Rp {{ number_format($result['user_kota']['umr'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">Waktu Tempuh</span>
                        <span class="font-semibold text-gray-100">{{ number_format($result['user_kota']['waktu_tempuh'], 0, ',', '.') }} detik/km</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">Jumlah Armada</span>
                        <span class="font-semibold text-gray-100">{{ number_format($result['user_kota']['jumlah_armada'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                        <span class="text-gray-400">Kendaraan Pribadi</span>
                        <span class="font-semibold text-gray-100">{{ number_format($result['user_kota']['jumlah_kendaraan_pribadi'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t-2 border-purple-500/30">
                        <span class="text-gray-300 font-semibold">Tarif Minimum</span>
                        <span class="font-bold text-purple-400 text-xl">Rp {{ number_format($result['user_kota']['tarif_minimum_aktual'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-300 font-semibold">Skor Preferensi</span>
                        <span class="font-bold text-purple-400 text-xl">{{ number_format($result['skor_user'], 4, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendation Card -->
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 rounded-2xl p-6 md:p-8 mb-8 shadow-2xl">
            <div class="text-center mb-6 md:mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 text-white">Tarif Rekomendasi</h2>
                <p class="text-cyan-100 text-sm sm:text-base">Berdasarkan perhitungan multikriteria</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 md:p-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 text-center">
                    <div>
                        <p class="text-cyan-100 text-xs sm:text-sm mb-2">Tarif Acuan ({{ $result['kota_pembanding']['nama_kota'] }})</p>
                        <p class="text-xl sm:text-2xl font-bold text-white">Rp {{ number_format($result['tarif_rekomendasi']['tarif_acuan'], 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-cyan-100 text-xs sm:text-sm mb-2">Rasio Skor</p>
                        <p class="text-xl sm:text-2xl font-bold text-white">
                            {{ number_format($result['tarif_rekomendasi']['skor_banding'] / $result['tarif_rekomendasi']['skor_acuan'], 4, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-cyan-100 text-xs sm:text-sm mb-2">Tarif Rekomendasi</p>
                        <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-yellow-300">
                            Rp {{ number_format($result['tarif_rekomendasi']['tarif_rekomendasi'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 md:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <p class="text-cyan-100 text-xs sm:text-sm mb-2">Tarif Aktual Anda</p>
                        <p class="text-lg sm:text-xl font-semibold text-white">Rp {{ number_format($result['user_kota']['tarif_minimum_aktual'], 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-cyan-100 text-xs sm:text-sm mb-2">Selisih</p>
                        <p class="text-lg sm:text-xl font-semibold {{ $result['tarif_rekomendasi']['selisih'] >= 0 ? 'text-green-300' : 'text-red-300' }}">
                            {{ $result['tarif_rekomendasi']['selisih'] >= 0 ? '+' : '' }}Rp {{ number_format($result['tarif_rekomendasi']['selisih'], 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-cyan-100 mt-1">
                            {{ $result['tarif_rekomendasi']['selisih'] >= 0 ? 'Tarif Anda lebih tinggi dari rekomendasi' : 'Tarif Anda lebih rendah dari rekomendasi' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculation Details -->
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 shadow-xl">
            <h3 class="text-xl md:text-2xl font-bold text-white mb-6 flex items-center">
                <i class="fas fa-calculator text-cyan-400 mr-3"></i>
                Detail Perhitungan
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-cyan-600 to-blue-600">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white rounded-tl-xl">Kriteria</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-white">Bobot</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-white rounded-tr-xl">Jenis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($kriteria as $kr)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <div>
                                        <span class="font-semibold text-cyan-400">{{ $kr->kode_kriteria }}</span>
                                        <span class="text-gray-400 ml-2">{{ $kr->nama_kriteria }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-semibold text-cyan-400">{{ number_format($bobot[$kr->kode_kriteria]->bobot, 4, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $kr->jenis == 'benefit' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                        {{ $kr->jenis == 'benefit' ? 'Benefit' : 'Cost' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
