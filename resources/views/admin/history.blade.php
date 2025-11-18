@extends('layouts.app')

@section('title', 'History Penggunaan - Admin Panel')

@section('content')
<div class="min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-2 text-white">History Penggunaan</h1>
                <p class="text-gray-400">Lihat semua history penggunaan sistem perhitungan tarif</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="mt-4 md:mt-0 px-6 py-3 bg-slate-700/50 border border-slate-600 text-gray-300 font-semibold rounded-xl hover:bg-slate-700 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 shadow-xl">
            @if($history->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-cyan-600 to-blue-600">
                                <th class="px-4 py-4 text-left text-sm font-bold text-white border-b-2 border-cyan-400/50">Tanggal & Waktu</th>
                                <th class="px-4 py-4 text-left text-sm font-bold text-white border-b-2 border-cyan-400/50">Kota User</th>
                                <th class="px-4 py-4 text-left text-sm font-bold text-white border-b-2 border-cyan-400/50">Kota Pembanding</th>
                                <th class="px-4 py-4 text-right text-sm font-bold text-white border-b-2 border-cyan-400/50">Tarif Aktual</th>
                                <th class="px-4 py-4 text-right text-sm font-bold text-white border-b-2 border-cyan-400/50">Tarif Rekomendasi</th>
                                <th class="px-4 py-4 text-right text-sm font-bold text-white border-b-2 border-cyan-400/50">Selisih</th>
                                <th class="px-4 py-4 text-right text-sm font-bold text-white border-b-2 border-cyan-400/50">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $hist)
                                <tr class="border-b border-slate-700/30 hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-4 text-gray-300 text-sm">
                                        @if($hist->created_at)
                                            <div class="font-medium text-white">{{ $hist->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-gray-400 mt-1">{{ $hist->created_at->format('H:i:s') }}</div>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-white text-sm mb-1">{{ ucfirst($hist->nama_kota_user) }}</div>
                                        <div class="text-xs text-gray-400">UMR: Rp {{ number_format($hist->umr_user, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($hist->kotaPembanding)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-cyan-500/20 text-cyan-300 font-medium text-sm border border-cyan-500/40">
                                                {{ $hist->kotaPembanding->nama_kota }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right text-gray-300 text-sm">
                                        <span class="font-medium">Rp {{ number_format($hist->tarif_minimum_aktual_user, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="font-bold text-cyan-400 text-sm">Rp {{ number_format($hist->tarif_rekomendasi, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg font-semibold text-sm {{ $hist->selisih >= 0 ? 'bg-green-500/20 text-green-300 border border-green-500/40' : 'bg-red-500/20 text-red-300 border border-red-500/40' }}">
                                            {{ $hist->selisih >= 0 ? '+' : '' }}Rp {{ number_format(abs($hist->selisih), 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right text-xs">
                                        <div class="space-y-1">
                                            <div class="text-cyan-400 font-medium">
                                                User: <span class="text-white font-semibold">{{ number_format($hist->skor_user, 4, ',', '.') }}</span>
                                            </div>
                                            <div class="text-gray-400">
                                                Pembanding: <span class="text-gray-300 font-semibold">{{ number_format($hist->skor_pembanding, 4, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-center">
                    {{ $history->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-history text-6xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Belum ada history penggunaan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
