@extends('layouts.app')

@section('title', 'Tambah Kota - Admin Panel')

@section('content')
<div class="min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.kota.index') }}" class="inline-flex items-center text-cyan-400 hover:text-cyan-300 mb-4">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Kota
            </a>
            <h1 class="text-3xl sm:text-4xl font-bold mb-2 text-white">Tambah Kota Pembanding</h1>
            <p class="text-gray-400">Tambahkan kota baru yang dapat digunakan sebagai pembanding</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 md:p-8 shadow-xl">
            <form action="{{ route('admin.kota.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Kota -->
                <div>
                    <label for="nama_kota" class="block text-sm font-semibold text-gray-300 mb-2">
                        Nama Kota <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_kota" 
                        name="nama_kota" 
                        value="{{ old('nama_kota') }}"
                        required
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('nama_kota') border-red-500 @enderror"
                        placeholder="Contoh: Jakarta, Surabaya, Medan..."
                    >
                    @error('nama_kota')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- UMR -->
                <div>
                    <label for="umr" class="block text-sm font-semibold text-gray-300 mb-2">
                        UMR (Upah Minimum Regional) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                        <input 
                            type="text" 
                            id="umr" 
                            name="umr" 
                            value="{{ old('umr') ? number_format(old('umr'), 0, ',', '.') : '' }}"
                            required
                            inputmode="numeric"
                            pattern="[0-9.,]*"
                            class="w-full pl-12 pr-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('umr') border-red-500 @enderror"
                            placeholder="4.209.309"
                        >
                    </div>
                    @error('umr')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Tempuh -->
                <div>
                    <label for="waktu_tempuh" class="block text-sm font-semibold text-gray-300 mb-2">
                        Waktu Tempuh Rata-rata (detik per km) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="waktu_tempuh" 
                            name="waktu_tempuh" 
                            value="{{ old('waktu_tempuh') ? number_format(old('waktu_tempuh'), 0, ',', '.') : '' }}"
                            required
                            inputmode="numeric"
                            pattern="[0-9.,]*"
                            class="w-full px-4 py-3 pr-20 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('waktu_tempuh') border-red-500 @enderror"
                            placeholder="1.957"
                        >
                        <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm font-medium">detik/km</span>
                    </div>
                    @error('waktu_tempuh')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Armada -->
                <div>
                    <label for="jumlah_armada" class="block text-sm font-semibold text-gray-300 mb-2">
                        Jumlah Armada Ojek Online <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="jumlah_armada" 
                        name="jumlah_armada" 
                        value="{{ old('jumlah_armada') ? number_format(old('jumlah_armada'), 0, ',', '.') : '' }}"
                        required
                        inputmode="numeric"
                        pattern="[0-9.,]*"
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('jumlah_armada') border-red-500 @enderror"
                        placeholder="30.000"
                    >
                    @error('jumlah_armada')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Kendaraan Pribadi -->
                <div>
                    <label for="jumlah_kendaraan_pribadi" class="block text-sm font-semibold text-gray-300 mb-2">
                        Jumlah Kendaraan Pribadi <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="jumlah_kendaraan_pribadi" 
                        name="jumlah_kendaraan_pribadi" 
                        value="{{ old('jumlah_kendaraan_pribadi') ? number_format(old('jumlah_kendaraan_pribadi'), 0, ',', '.') : '' }}"
                        required
                        inputmode="numeric"
                        pattern="[0-9.,]*"
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('jumlah_kendaraan_pribadi') border-red-500 @enderror"
                        placeholder="2.360.000"
                    >
                    @error('jumlah_kendaraan_pribadi')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tarif Minimum Aktual -->
                <div>
                    <label for="tarif_minimum_aktual" class="block text-sm font-semibold text-gray-300 mb-2">
                        Tarif Minimum Aktual (Rp) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                        <input 
                            type="text" 
                            id="tarif_minimum_aktual" 
                            name="tarif_minimum_aktual" 
                            value="{{ old('tarif_minimum_aktual') ? number_format(old('tarif_minimum_aktual'), 0, ',', '.') : '' }}"
                            required
                            inputmode="numeric"
                            pattern="[0-9.,]*"
                            class="w-full pl-12 pr-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('tarif_minimum_aktual') border-red-500 @enderror"
                            placeholder="6.000"
                        >
                    </div>
                    @error('tarif_minimum_aktual')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('admin.kota.index') }}" class="flex-1 px-6 py-3 bg-slate-700/50 border border-slate-600 text-gray-300 font-semibold rounded-xl hover:bg-slate-700 transition-all duration-200 text-center">
                        Batal
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-[1.02] transition-all duration-200 shadow-lg shadow-cyan-500/50"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Simpan Kota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

