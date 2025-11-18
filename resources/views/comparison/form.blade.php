@extends('layouts.app')

@section('title', 'Hitung Tarif - Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online')

@section('content')
<div class="min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-white">
                Hitung Tarif Transportasi
            </h1>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto">
                Masukkan data kota Anda dan pilih kota pembanding untuk menggunakan sistem perhitungan multikriteria
            </p>
        </div>

        <!-- Alert Messages -->
        @if(session('error'))
            <div class="bg-red-500/10 border-l-4 border-red-500 rounded-lg p-4 mb-6 backdrop-blur-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-300">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 md:p-8 lg:p-10 mb-8 shadow-xl">
            <form action="{{ route('comparison.compare') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Kota Pembanding -->
                <div>
                    <label for="kota_pembanding_id" class="block text-sm font-semibold text-gray-300 mb-2">
                        Pilih Kota Pembanding <span class="text-red-400">*</span>
                    </label>
                    <select 
                        id="kota_pembanding_id" 
                        name="kota_pembanding_id" 
                        required
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 @error('kota_pembanding_id') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Kota Pembanding --</option>
                        @foreach($kotaPembanding as $kota)
                            <option value="{{ $kota->id }}" {{ old('kota_pembanding_id') == $kota->id ? 'selected' : '' }}>
                                {{ $kota->nama_kota }}
                            </option>
                        @endforeach
                    </select>
                    @error('kota_pembanding_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Pilih kota yang akan digunakan sebagai acuan perbandingan</p>
                </div>

                <!-- City Name -->
                <div>
                    <label for="city_name" class="block text-sm font-semibold text-gray-300 mb-2">
                        Nama Kota Anda <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="city_name" 
                        name="city_name" 
                        value="{{ old('city_name') }}"
                        required
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('city_name') border-red-500 @enderror"
                        placeholder="Contoh: Jakarta, Surabaya, Medan..."
                    >
                    @error('city_name')
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
                    <p class="mt-2 text-xs text-gray-500">Contoh: 4209309</p>
                </div>

                <!-- Average Time -->
                <div>
                    <label for="avg_time" class="block text-sm font-semibold text-gray-300 mb-2">
                        Waktu Tempuh Rata-rata <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="avg_time" 
                            name="avg_time" 
                            value="{{ old('avg_time') ? number_format(old('avg_time'), 0, ',', '.') : '' }}"
                            required
                            inputmode="numeric"
                            pattern="[0-9.,]*"
                            class="w-full px-4 py-3 pr-20 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('avg_time') border-red-500 @enderror"
                            placeholder="1.957"
                        >
                        <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm font-medium">detik/km</span>
                    </div>
                    @error('avg_time')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Contoh: 1957</p>
                </div>

                <!-- Armada Count -->
                <div>
                    <label for="armada_count" class="block text-sm font-semibold text-gray-300 mb-2">
                        Jumlah Armada Ojek Online <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="armada_count" 
                        name="armada_count" 
                        value="{{ old('armada_count') ? number_format(old('armada_count'), 0, ',', '.') : '' }}"
                        required
                        inputmode="numeric"
                        pattern="[0-9.,]*"
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('armada_count') border-red-500 @enderror"
                        placeholder="30.000"
                    >
                    @error('armada_count')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Contoh: 30000</p>
                </div>

                <!-- Private Vehicle -->
                <div>
                    <label for="private_vehicle" class="block text-sm font-semibold text-gray-300 mb-2">
                        Jumlah Kendaraan Pribadi <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="private_vehicle" 
                        name="private_vehicle" 
                        value="{{ old('private_vehicle') ? number_format(old('private_vehicle'), 0, ',', '.') : '' }}"
                        required
                        inputmode="numeric"
                        pattern="[0-9.,]*"
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('private_vehicle') border-red-500 @enderror"
                        placeholder="2.360.000"
                    >
                    @error('private_vehicle')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Contoh: 2360000</p>
                </div>

                <!-- Actual Min Tarif -->
                <div>
                    <label for="actual_min_tarif" class="block text-sm font-semibold text-gray-300 mb-2">
                        Tarif Minimum Aktual <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                        <input 
                            type="text" 
                            id="actual_min_tarif" 
                            name="actual_min_tarif" 
                            value="{{ old('actual_min_tarif') ? number_format(old('actual_min_tarif'), 0, ',', '.') : '' }}"
                            required
                            inputmode="numeric"
                            pattern="[0-9.,]*"
                            class="w-full pl-12 pr-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 placeholder-gray-500 @error('actual_min_tarif') border-red-500 @enderror"
                            placeholder="6.000"
                        >
                    </div>
                    @error('actual_min_tarif')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Contoh: 6000</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button 
                        type="submit"
                        class="w-full px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-[1.02] transition-all duration-200 shadow-lg shadow-cyan-500/50 flex items-center justify-center"
                    >
                        <i class="fas fa-calculator mr-2"></i>
                        <span>Hitung Perbandingan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="bg-cyan-500/10 border border-cyan-500/30 rounded-2xl p-6 backdrop-blur-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="font-bold text-cyan-300 mb-2">Tentang Perhitungan</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Sistem ini akan membandingkan data kota Anda dengan kota pembanding yang dipilih menggunakan 
                        <strong class="text-white">sistem perhitungan multikriteria</strong> yang menganalisis berbagai faktor penting 
                        untuk memberikan rekomendasi tarif transportasi online yang akurat dan terpercaya.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
