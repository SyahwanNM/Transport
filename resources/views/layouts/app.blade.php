<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        .animated-background {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        
        /* Animated Gradient Mesh */
        .gradient-mesh {
            position: absolute;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(at 0% 0%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                radial-gradient(at 0% 100%, rgba(236, 72, 153, 0.15) 0%, transparent 50%);
            animation: meshMove 20s ease-in-out infinite;
        }
        
        @keyframes meshMove {
            0%, 100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
            50% {
                transform: scale(1.2) rotate(5deg);
                opacity: 0.8;
            }
        }
        
        /* Floating Blobs dengan Morphing */
        .blob {
            position: absolute;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            filter: blur(60px);
            opacity: 0.4;
            animation: blobFloat 25s ease-in-out infinite, blobMorph 15s ease-in-out infinite;
        }
        
        .blob-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            top: -300px;
            left: -300px;
            animation-delay: 0s;
        }
        
        .blob-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            bottom: -250px;
            right: -250px;
            animation-delay: 5s;
        }
        
        .blob-3 {
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }
        
        .blob-4 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            top: 20%;
            right: 10%;
            animation-delay: 15s;
        }
        
        @keyframes blobFloat {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(50px, -50px) scale(1.1);
            }
            50% {
                transform: translate(-30px, 30px) scale(0.9);
            }
            75% {
                transform: translate(40px, 20px) scale(1.05);
            }
        }
        
        @keyframes blobMorph {
            0%, 100% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            }
            25% {
                border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;
            }
            50% {
                border-radius: 50% 50% 50% 50% / 50% 50% 50% 50%;
            }
            75% {
                border-radius: 30% 70% 50% 50% / 50% 50% 70% 30%;
            }
        }
        
        /* Animated Grid dengan Perspective */
        .grid-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(6, 182, 212, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(6, 182, 212, 0.08) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridSlide 30s linear infinite;
            opacity: 0.5;
            perspective: 1000px;
        }
        
        @keyframes gridSlide {
            0% {
                transform: translate(0, 0) perspective(1000px) rotateX(0deg);
            }
            50% {
                transform: translate(60px, 60px) perspective(1000px) rotateX(2deg);
            }
            100% {
                transform: translate(0, 0) perspective(1000px) rotateX(0deg);
            }
        }
        
        /* Light Rays Effect */
        .light-rays {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: 
                conic-gradient(from 0deg at 50% 50%, 
                    transparent 0deg,
                    rgba(6, 182, 212, 0.1) 60deg,
                    transparent 120deg,
                    rgba(139, 92, 246, 0.1) 180deg,
                    transparent 240deg,
                    rgba(59, 130, 246, 0.1) 300deg,
                    transparent 360deg
                );
            animation: rotateRays 40s linear infinite;
            opacity: 0.6;
        }
        
        @keyframes rotateRays {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        
        /* Floating Particles - Multiple dengan berbagai ukuran dan gerakan */
        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        
        /* Small particles */
        .particle-small {
            width: 3px;
            height: 3px;
            background: rgba(6, 182, 212, 0.8);
            box-shadow: 0 0 6px rgba(6, 182, 212, 0.6);
            animation: particleMove1 20s linear infinite;
        }
        
        /* Medium particles */
        .particle-medium {
            width: 5px;
            height: 5px;
            background: rgba(139, 92, 246, 0.7);
            box-shadow: 0 0 8px rgba(139, 92, 246, 0.5);
            animation: particleMove2 25s linear infinite;
        }
        
        /* Large particles */
        .particle-large {
            width: 8px;
            height: 8px;
            background: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
            animation: particleMove3 30s linear infinite;
        }
        
        /* Glowing particles */
        .particle-glow {
            width: 4px;
            height: 4px;
            background: rgba(236, 72, 153, 0.9);
            box-shadow: 0 0 12px rgba(236, 72, 153, 0.8), 0 0 24px rgba(236, 72, 153, 0.4);
            animation: particleMove4 18s linear infinite;
        }
        
        /* Particle movement patterns */
        @keyframes particleMove1 {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            90% {
                opacity: 0.8;
            }
            100% {
                transform: translate(100vw, -100vh) scale(0.5);
                opacity: 0;
            }
        }
        
        @keyframes particleMove2 {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.7;
            }
            90% {
                opacity: 0.7;
            }
            100% {
                transform: translate(-100vw, 100vh) scale(1.2) rotate(360deg);
                opacity: 0;
            }
        }
        
        @keyframes particleMove3 {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            50% {
                transform: translate(50vw, -50vh) scale(1.5);
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translate(100vw, 100vh) scale(0.8);
                opacity: 0;
            }
        }
        
        @keyframes particleMove4 {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 0.9;
            }
            50% {
                transform: translate(-50vw, 50vh) scale(1.3);
            }
            90% {
                opacity: 0.9;
            }
            100% {
                transform: translate(-100vw, -100vh) scale(0.7);
                opacity: 0;
            }
        }
        
        /* Zigzag movement */
        @keyframes particleZigzag {
            0% {
                transform: translate(0, 0);
                opacity: 0;
            }
            10% {
                opacity: 0.7;
            }
            25% {
                transform: translate(30px, -30px);
            }
            50% {
                transform: translate(-20px, 20px);
            }
            75% {
                transform: translate(40px, -20px);
            }
            90% {
                opacity: 0.7;
            }
            100% {
                transform: translate(100vw, 100vh);
                opacity: 0;
            }
        }
        
        /* Circular movement */
        @keyframes particleCircle {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            50% {
                transform: translate(200px, -200px) rotate(180deg);
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translate(0, 0) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Wave Animation */
        .wave {
            position: absolute;
            width: 200%;
            height: 200%;
            bottom: -50%;
            left: -50%;
            background: radial-gradient(ellipse at center, rgba(6, 182, 212, 0.1) 0%, transparent 70%);
            animation: waveMove 20s ease-in-out infinite;
        }
        
        @keyframes waveMove {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            50% {
                transform: translate(50px, -30px) scale(1.1);
                opacity: 0.5;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-slate-900 text-gray-100 min-h-screen">
    <div class="animated-background">
        <div class="gradient-mesh"></div>
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
        <div class="grid-overlay"></div>
        <div class="light-rays"></div>
        <div class="wave"></div>
        
        <!-- Floating Particles dengan berbagai ukuran dan pola gerakan -->
        <div class="particle particle-small" style="left: 5%; top: 10%; animation-delay: 0s;"></div>
        <div class="particle particle-medium" style="left: 15%; top: 30%; animation-delay: 1s;"></div>
        <div class="particle particle-small" style="left: 25%; top: 50%; animation-delay: 2s;"></div>
        <div class="particle particle-glow" style="left: 35%; top: 20%; animation-delay: 0.5s;"></div>
        <div class="particle particle-large" style="left: 45%; top: 70%; animation-delay: 3s;"></div>
        <div class="particle particle-small" style="left: 55%; top: 15%; animation-delay: 1.5s;"></div>
        <div class="particle particle-medium" style="left: 65%; top: 60%; animation-delay: 2.5s;"></div>
        <div class="particle particle-glow" style="left: 75%; top: 40%; animation-delay: 0.8s;"></div>
        <div class="particle particle-small" style="left: 85%; top: 25%; animation-delay: 3.5s;"></div>
        <div class="particle particle-large" style="left: 95%; top: 80%; animation-delay: 1.2s;"></div>
        <div class="particle particle-medium" style="left: 10%; top: 90%; animation-delay: 2.2s;"></div>
        <div class="particle particle-small" style="left: 30%; top: 5%; animation-delay: 4s;"></div>
        <div class="particle particle-glow" style="left: 50%; top: 95%; animation-delay: 1.8s;"></div>
        <div class="particle particle-medium" style="left: 70%; top: 10%; animation-delay: 2.8s;"></div>
        <div class="particle particle-small" style="left: 90%; top: 55%; animation-delay: 0.3s;"></div>
        <div class="particle particle-large" style="left: 20%; top: 75%; animation-delay: 3.2s;"></div>
        <div class="particle particle-glow" style="left: 40%; top: 35%; animation-delay: 1.7s;"></div>
        <div class="particle particle-small" style="left: 60%; top: 85%; animation-delay: 2.3s;"></div>
        <div class="particle particle-medium" style="left: 80%; top: 65%; animation-delay: 0.7s;"></div>
        <div class="particle particle-small" style="left: 5%; top: 45%; animation-delay: 3.8s;"></div>
    </div>
    
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="{{ route('home') }}" class="text-xl md:text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">
                    TarifCalculator
                </a>
                
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-cyan-500/20 text-cyan-400' : 'text-gray-400 hover:text-cyan-400 hover:bg-slate-800' }}">
                        Beranda
                    </a>
                    <a href="{{ route('comparison.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('comparison.*') ? 'bg-cyan-500/20 text-cyan-400' : 'text-gray-400 hover:text-cyan-400 hover:bg-slate-800' }}">
                        Hitung Tarif
                    </a>
                </div>
                
                <button class="md:hidden text-gray-400 hover:text-cyan-400 p-2" id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="hidden md:hidden pb-4 border-t border-slate-700/50 mt-2" id="mobile-menu">
                <div class="flex flex-col space-y-1 pt-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'bg-cyan-500/20 text-cyan-400' : 'text-gray-400 hover:text-cyan-400' }}">Beranda</a>
                    <a href="{{ route('comparison.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('comparison.*') ? 'bg-cyan-500/20 text-cyan-400' : 'text-gray-400 hover:text-cyan-400' }}">Hitung Tarif</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="relative z-10 pt-16 md:pt-20">
        @yield('content')
    </div>
    
    <!-- Footer -->
    <footer class="relative z-10 bg-slate-900/80 backdrop-blur-md border-t border-slate-700/50 py-8 mt-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} TarifCalculator. Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online.
            </p>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Format angka dengan titik sebagai pemisah ribuan (format Indonesia)
            function formatNumberWithDot(text) {
                if (!text || typeof text !== 'string') return text;
                
                // Format semua angka 4 digit atau lebih, atau yang sudah punya pemisah
                // Contoh: "4209309" -> "4.209.309"
                // Contoh: "4,209,309" -> "4.209.309"
                // Contoh: "Rp 4209309" -> "Rp 4.209.309"
                // Contoh: "1957" -> "1.957"
                
                return text.replace(/(\d{1,3}(?:[.,]\d{3})*|\d{4,})/g, function(match) {
                    // Hapus semua koma dan titik yang sudah ada (pemisah ribuan)
                    let cleanNumber = match.replace(/[,.]/g, '');
                    
                    // Cek apakah ada desimal (titik di akhir dengan 1-6 digit setelahnya)
                    // Tapi kita perlu hati-hati karena titik bisa jadi pemisah ribuan
                    // Untuk sekarang, kita asumsikan tidak ada desimal karena PHP number_format dengan 0 decimal
                    
                    // Format dengan titik sebagai pemisah ribuan (setiap 3 digit dari kanan)
                    const formatted = cleanNumber.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    return formatted;
                });
            }

            // Format semua angka di halaman
            function formatAllNumbers() {
                // Pilih elemen yang mungkin mengandung angka
                const selectors = 'td, th, span, p, div, li';
                const elements = document.querySelectorAll(selectors);
                
                elements.forEach(element => {
                    // Skip jika sudah diformat atau elemen input/form
                    if (element.dataset.formatted === 'true' || 
                        element.dataset.noFormat === 'true' ||
                        element.dataset.protected === 'true' ||
                        element.tagName === 'INPUT' || 
                        element.tagName === 'TEXTAREA' ||
                        element.tagName === 'SCRIPT' ||
                        element.tagName === 'STYLE' ||
                        element.closest('script') ||
                        element.closest('style') ||
                        element.closest('input') ||
                        element.closest('textarea') ||
                        element.closest('table') ||
                        element.closest('thead') ||
                        element.closest('tbody') ||
                        element.closest('tfoot') ||
                        element.closest('tr') ||
                        element.closest('th') ||
                        element.closest('td') ||
                        element.closest('[data-no-format="true"]') ||
                        element.closest('[data-protected="true"]')) {
                        return;
                    }
                    
                    // Skip jika elemen memiliki child nodes yang kompleks (kemungkinan mengandung HTML)
                    if (element.children.length > 0 && element.textContent !== element.innerText) {
                        return;
                    }
                    
                    // Skip jika elemen kosong atau tidak mengandung angka
                    const originalText = element.textContent;
                    if (!originalText || !originalText.trim() || !/\d/.test(originalText)) {
                        return;
                    }
                    
                    // Format semua angka 4 digit atau lebih (atau yang sudah punya koma/titik)
                    // Skip hanya angka 1-3 digit yang tidak perlu format
                    const hasLargeNumber = /\d{4,}/.test(originalText) || /[,.]/.test(originalText);
                    if (!hasLargeNumber && originalText.match(/^\d{1,3}$/)) {
                        return;
                    }
                    
                    // Format angka
                    const formattedText = formatNumberWithDot(originalText);
                    
                    // Update jika ada perubahan
                    if (originalText !== formattedText) {
                        element.textContent = formattedText;
                        element.dataset.formatted = 'true';
                    }
                });
            }

            // Jalankan format saat halaman dimuat (dengan delay kecil untuk memastikan DOM siap)
            setTimeout(function() {
                formatAllNumbers();
            }, 100);
            
            // Jalankan lagi setelah 500ms untuk memastikan semua konten sudah dimuat
            setTimeout(function() {
                formatAllNumbers();
            }, 500);

            // Format ulang jika ada konten yang ditambahkan secara dinamis
            const observer = new MutationObserver(function(mutations) {
                let shouldFormat = false;
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        shouldFormat = true;
                    }
                });
                if (shouldFormat) {
                    setTimeout(formatAllNumbers, 50);
                }
            });

            // Observe perubahan di body
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Format angka di input field secara real-time
            function formatInputNumber(input) {
                // Simpan cursor position
                const cursorPosition = input.selectionStart;
                const oldValue = input.value;
                
                // Hapus semua karakter non-digit
                let value = input.value.replace(/[^\d]/g, '');
                
                // Format dengan titik setiap 3 digit dari kanan
                if (value.length > 3) {
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                
                input.value = value;
                
                // Restore cursor position (adjust untuk perubahan panjang)
                const newValue = input.value;
                const lengthDiff = newValue.length - oldValue.length;
                const newCursorPosition = Math.min(cursorPosition + lengthDiff, newValue.length);
                input.setSelectionRange(newCursorPosition, newCursorPosition);
            }

            // Tambahkan event listener untuk semua input text dengan pattern numeric
            function setupInputFormatting() {
                // Pilih input yang memiliki inputmode="numeric" atau pattern numeric
                const numericInputs = document.querySelectorAll('input[inputmode="numeric"], input[pattern*="0-9"]');
                
                numericInputs.forEach(input => {
                    // Skip jika sudah di-setup
                    if (input.dataset.formatted === 'true') {
                        return;
                    }
                    
                    // Tambahkan event listener untuk input
                    input.addEventListener('input', function(e) {
                        formatInputNumber(e.target);
                    });

                    // Format saat blur (ketika user selesai mengetik)
                    input.addEventListener('blur', function(e) {
                        formatInputNumber(e.target);
                    });

                    // Format saat halaman dimuat jika ada value
                    if (input.value) {
                        formatInputNumber(input);
                    }
                    
                    // Mark sebagai sudah di-setup
                    input.dataset.formatted = 'true';
                });
            }

            // Setup input formatting saat halaman dimuat
            setTimeout(setupInputFormatting, 100);
            setTimeout(setupInputFormatting, 500);

            // Setup juga untuk input yang ditambahkan secara dinamis
            const inputObserver = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        setTimeout(setupInputFormatting, 50);
                    }
                });
            });

            inputObserver.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
