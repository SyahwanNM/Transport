@extends('layouts.app')

@section('title', 'Beranda - Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                <span class="block text-white mb-2">Hitung Tarif Transportasi</span>
                <span class="block bg-gradient-to-r from-cyan-400 via-blue-400 to-purple-400 bg-clip-text text-transparent">
                    dengan Perhitungan Multikriteria
                </span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-gray-300 mb-10 max-w-3xl mx-auto leading-relaxed">
                Dapatkan rekomendasi tarif transportasi online yang akurat dengan membandingkan data kota Anda dengan kota Bandung menggunakan sistem perhitungan multikriteria yang canggih.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('comparison.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-cyan-500/50">
                    <span>Mulai Hitung Sekarang</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 md:py-24 relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                <span class="text-white">Mengapa Pilih</span>
                <span class="block sm:inline sm:ml-2 bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">
                    Sistem Kami?
                </span>
            </h2>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto">
                Sistem perhitungan yang menggunakan metode ilmiah terpercaya untuk memberikan rekomendasi tarif yang akurat.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto">
            <!-- Feature 1 -->
            <div class="group bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 md:p-8 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-cyan-500/30">
                    <i class="fas fa-chart-line text-white text-2xl md:text-3xl"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Analisis Multikriteria</h3>
                <p class="text-gray-400 leading-relaxed">
                    Sistem menganalisis berbagai kriteria penting seperti UMR, waktu tempuh, jumlah armada, dan kendaraan pribadi untuk memberikan penilaian yang komprehensif.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="group bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 md:p-8 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-cyan-500/30">
                    <i class="fas fa-balance-scale text-white text-2xl md:text-3xl"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Perhitungan Terstruktur</h3>
                <p class="text-gray-400 leading-relaxed">
                    Setiap kriteria dinilai dengan bobot yang tepat dan dihitung secara sistematis untuk menghasilkan skor preferensi yang objektif dan akurat.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="group bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 md:p-8 hover:border-cyan-500/50 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-cyan-500/30">
                    <i class="fas fa-calculator text-white text-2xl md:text-3xl"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Rekomendasi Akurat</h3>
                <p class="text-gray-400 leading-relaxed">
                    Dapatkan rekomendasi tarif minimum transportasi online yang akurat berdasarkan perbandingan komprehensif dengan kota Bandung sebagai acuan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-16 md:py-24 relative bg-slate-800/30">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                Cara <span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Menggunakan</span>
            </h2>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto">
                Hanya 3 langkah sederhana untuk mendapatkan rekomendasi tarif yang akurat.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 max-w-5xl mx-auto">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl md:text-3xl font-bold shadow-lg shadow-cyan-500/50">
                    1
                </div>
                <h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Input Data</h3>
                <p class="text-gray-400 leading-relaxed">
                    Masukkan data kota Anda meliputi UMR, waktu tempuh, jumlah armada, kendaraan pribadi, dan tarif minimum aktual melalui form yang mudah digunakan.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl md:text-3xl font-bold shadow-lg shadow-cyan-500/50">
                    2
                </div>
                <h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Proses Perhitungan</h3>
                <p class="text-gray-400 leading-relaxed">
                    Sistem akan membandingkan data Anda dengan kota Bandung menggunakan perhitungan multikriteria untuk menghitung skor preferensi secara otomatis.
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl md:text-3xl font-bold shadow-lg shadow-cyan-500/50">
                    3
                </div>
                <h3 class="text-xl md:text-2xl font-bold mb-4 text-white">Dapatkan Hasil</h3>
                <p class="text-gray-400 leading-relaxed">
                    Lihat rekomendasi tarif berdasarkan perbandingan skor preferensi dan analisis detail perhitungan yang transparan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 md:py-24 relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-3xl p-8 md:p-12 text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 text-white">
                Siap Memulai?
            </h2>
            <p class="text-lg sm:text-xl text-gray-400 mb-8 leading-relaxed max-w-2xl mx-auto">
                Masukkan data kota Anda sekarang dan dapatkan rekomendasi tarif transportasi online yang akurat dalam hitungan detik.
            </p>
            <a href="{{ route('comparison.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-cyan-500/50">
                <span>Mulai Hitung Tarif Sekarang</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection
