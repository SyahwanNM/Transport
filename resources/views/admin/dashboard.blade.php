@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online')

@section('content')
<div class="min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-2 text-white">
                    Dashboard Admin
                </h1>
                <p class="text-gray-400">Kelola kota pembanding dan lihat history penggunaan</p>
            </div>
            <a href="{{ route('admin.logout') }}" class="mt-4 md:mt-0 px-6 py-3 bg-red-500/20 border border-red-500/30 text-red-400 font-semibold rounded-xl hover:bg-red-500/30 transition-all duration-200">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Logout
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                <p class="text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Kota Pembanding</p>
                        <p class="text-3xl font-bold text-white">{{ $totalKota }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-city text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total History Penggunaan</p>
                        <p class="text-3xl font-bold text-white">{{ $totalHistory }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ route('admin.kota.index') }}" class="flex-1 px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-cyan-500/50 text-center">
                <i class="fas fa-city mr-2"></i>
                Kelola Kota Pembanding
            </a>
            <a href="{{ route('admin.history') }}" class="flex-1 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-purple-500/50 text-center">
                <i class="fas fa-history mr-2"></i>
                Lihat History
            </a>
        </div>

        <!-- Recent History -->
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6">
            <h2 class="text-2xl font-bold text-white mb-6">History Terbaru</h2>
            @if($recentHistory->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-cyan-600 to-blue-600">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-white rounded-tl-xl">Tanggal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-white">Kota User</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-white">Kota Pembanding</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-white rounded-tr-xl">Tarif Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @foreach($recentHistory as $hist)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 text-gray-300 text-sm">
                                        @if($hist->created_at)
                                            {{ $hist->created_at->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-300 font-medium">{{ $hist->nama_kota_user }}</td>
                                    <td class="px-4 py-3 text-cyan-400 font-medium">{{ $hist->kotaPembanding->nama_kota }}</td>
                                    <td class="px-4 py-3 text-right text-cyan-400 font-semibold">
                                        Rp {{ number_format($hist->tarif_rekomendasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">Belum ada history penggunaan</p>
            @endif
        </div>
    </div>
</div>
@endsection

