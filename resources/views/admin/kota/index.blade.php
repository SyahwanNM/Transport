@extends('layouts.app')

@section('title', 'Kelola Kota - Admin Panel')

@section('content')
<div class="min-h-screen py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-2 text-white">Kelola Kota Pembanding</h1>
                <p class="text-gray-400">Tambah, edit, atau hapus kota yang digunakan sebagai pembanding</p>
            </div>
            <div class="flex gap-4 mt-4 md:mt-0">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-slate-700/50 border border-slate-600 text-gray-300 font-semibold rounded-xl hover:bg-slate-700 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <a href="{{ route('admin.kota.create') }}" class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-cyan-500/50">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kota
                </a>
            </div>
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

        <!-- Kota List -->
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-6 overflow-x-auto">
            @if($kota->count() > 0)
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="bg-gradient-to-r from-cyan-600 to-blue-600">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white rounded-tl-xl">Nama Kota</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-white">UMR</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-white">Waktu Tempuh</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-white">Armada</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-white">Kendaraan Pribadi</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-white">Tarif Minimum</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-white rounded-tr-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($kota as $k)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-white">{{ $k->nama_kota }}</span>
                                </td>
                                <td class="px-4 py-3 text-right text-gray-300">
                                    Rp {{ number_format($k->umr, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-300">
                                    {{ number_format($k->waktu_tempuh, 0, ',', '.') }} detik/km
                                </td>
                                <td class="px-4 py-3 text-right text-gray-300">
                                    {{ number_format($k->jumlah_armada, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-300">
                                    {{ number_format($k->jumlah_kendaraan_pribadi, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right text-cyan-400 font-semibold">
                                    Rp {{ number_format($k->tarif_minimum_aktual, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.kota.edit', $k->id) }}" class="px-3 py-1.5 bg-blue-500/20 border border-blue-500/30 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-all text-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.kota.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kota ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-500/20 border border-red-500/30 text-red-400 rounded-lg hover:bg-red-500/30 transition-all text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-city text-6xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400 mb-6">Belum ada kota pembanding. Tambahkan kota pertama Anda!</p>
                    <a href="{{ route('admin.kota.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-cyan-500/50">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kota Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

