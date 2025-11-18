@extends('layouts.app')

@section('title', 'Login Admin - Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-md">
        <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Admin Login</h1>
                <p class="text-gray-400">Masukkan password untuk mengakses panel admin</p>
            </div>

            @if(session('error'))
                <div class="bg-red-500/10 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                    <p class="text-red-300 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-500/10 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                    <p class="text-green-300 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">
                        Password Admin
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 bg-slate-900/50 border border-slate-600 text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200"
                        placeholder="Masukkan password admin"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-600 transform hover:scale-[1.02] transition-all duration-200 shadow-lg shadow-cyan-500/50"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-cyan-400 hover:text-cyan-300 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

