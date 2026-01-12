@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
body {
    background: #ffffff;
}

.hero-overlay {
    background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(244, 114, 0, 0.4) 100%);
}

.glass-nav {
    background: rgba(17, 24, 39, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(244, 114, 0, 0.1);
}

.glass-orange {
    background: rgba(244, 114, 0, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(244, 114, 0, 0.2);
}

.wave-divider {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.wave-divider svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 60px;
}

.stat-card {
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f47200, #ff8c00);
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.animate-float {
    animation: float 5s ease-in-out infinite;
}

.feature-icon {
    background: linear-gradient(135deg, #f47200 0%, #ff8c00 100%);
}
@endsection

@section('content')
<!-- Navbar -->
<nav class="glass-nav fixed w-full z-50 shadow-xl">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-lg">
                    @if($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="w-8 h-8 rounded object-cover">
                    @else
                        <i class="fas fa-mosque text-white text-lg"></i>
                    @endif
                </div>
                <div>
                    <h1 class="font-bold text-white text-sm">{{ Str::limit($pengaturan->nama_pesantren ?? 'PP Al-Badru', 30) }}</h1>
                    <p class="text-xs text-gray-300">Cimahi, Jawa Barat</p>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-6">
                <a href="#beranda" class="text-sm text-gray-200 hover:text-white transition">Beranda</a>
                <a href="#tentang" class="text-sm text-gray-200 hover:text-white transition">Tentang</a>
                <a href="#program" class="text-sm text-gray-200 hover:text-white transition">Program</a>
                <a href="#alur" class="text-sm text-gray-200 hover:text-white transition">Alur</a>
                <a href="#kontak" class="text-sm text-gray-200 hover:text-white transition">Kontak</a>
            </div>
            
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pendaftar.dashboard') }}" 
                       class="px-5 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition font-medium text-sm shadow-lg">
                        <i class="fas fa-tachometer-alt mr-1.5"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-white hover:bg-white/10 rounded-lg transition text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition font-medium text-sm shadow-lg">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero with Video Background -->
<section id="beranda" class="relative h-screen flex items-center overflow-hidden">
    <!-- Video Background -->
    <div class="absolute inset-0">
        @if($banners->count() > 0 && $banners->first()->tipe === 'video')
            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="{{ asset('storage/' . $banners->first()->file) }}" type="video/mp4">
            </video>
        @else
            <img src="https://images.unsplash.com/photo-1580130732478-d3a6e8ec7e1f?w=1920" alt="Hero" class="w-full h-full object-cover">
        @endif
        <div class="hero-overlay absolute inset-0"></div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <div class="inline-flex items-center px-4 py-2 glass-orange rounded-full text-white text-sm mb-6 animate-float">
                <i class="fas fa-star text-yellow-300 mr-2"></i>
                <span class="font-medium">Pendaftaran Santri Baru {{ date('Y') }} Dibuka</span>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white leading-tight">
                Solusi Pasti Meraih
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-400">
                    Kompetensi
                </span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-100 mb-8 leading-relaxed max-w-2xl">
                Mari bergabung menjadi keluarga {{ $pengaturan->nama_pesantren ?? 'STMIK Mardira Indonesia' }} dengan perkuliahan yang modern, fasilitas lengkap, dan dosen berpengalaman.
            </p>
            
            <div class="flex flex-wrap gap-4">
                @if($periodeAktif)
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-semibold transition shadow-2xl">
                        Mulai Bergabung
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                @endif
                <a href="#program" class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-md hover:bg-white/30 text-white rounded-lg font-semibold transition border border-white/30">
                    Jelajahi Program Studi
                </a>
            </div>
        </div>
    </div>
    
    <div class="wave-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- Stats -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Kenapa Memilih Kami</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-orange-500 to-orange-600 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
            <div class="stat-card glass-card p-6 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-award text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-500 mb-2">98%</div>
                <p class="text-gray-600 text-sm">Lulusan Bekerja</p>
            </div>
            
            <div class="stat-card glass-card p-6 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-500 mb-2">45+</div>
                <p class="text-gray-600 text-sm">Nasional Partners</p>
            </div>
            
            <div class="stat-card glass-card p-6 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-500 mb-2">1200+</div>
                <p class="text-gray-600 text-sm">Mahasiswa Aktif</p>
            </div>
            
            <div class="stat-card glass-card p-6 rounded-xl shadow-lg hover:shadow-2xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-orange-500 mb-2">4</div>
                <p class="text-gray-600 text-sm">Program Studi</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-20 bg-gradient-to-br from-orange-50 to-white">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="order-2 md:order-1">
                <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800" 
                     alt="Tentang" class="rounded-2xl shadow-2xl">
            </div>
            <div class="order-1 md:order-2 space-y-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Tentang Kami</h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-orange-500 to-orange-600 mb-6"></div>
                </div>
                
                <div class="glass-card p-6 rounded-xl shadow-lg border-l-4 border-orange-500">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 feature-icon">
                            <i class="fas fa-eye text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-2">Visi</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Mencetak kader umat yang cerdas secara intelektual dan memiliki keagungan akhlak.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="glass-card p-6 rounded-xl shadow-lg border-l-4 border-orange-500">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 feature-icon">
                            <i class="fas fa-bullseye text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-3">Misi</h4>
                            <ul class="space-y-2 text-gray-600 text-sm">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-orange-500 mt-0.5 flex-shrink-0"></i>
                                    <span>Memberikan pendidikan berkualitas tinggi</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-orange-500 mt-0.5 flex-shrink-0"></i>
                                    <span>Membentuk karakter berakhlak mulia</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-orange-500 mt-0.5 flex-shrink-0"></i>
                                    <span>Mengembangkan kompetensi profesional</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program -->
<section id="program" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Program Unggulan</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-orange-500 to-orange-600 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Pilihan program studi terbaik dengan kurikulum industri</p>
        </div>
        
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-6">
            <div class="glass-card p-8 rounded-xl shadow-lg hover:shadow-2xl transition border-t-4 border-orange-500 group">
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center feature-icon group-hover:scale-110 transition">
                    <i class="fas fa-laptop-code text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2 text-center">Teknik Informatika</h4>
                <p class="text-gray-600 text-sm text-center">Program studi unggulan dengan fokus pengembangan software</p>
            </div>
            
            <div class="glass-card p-8 rounded-xl shadow-lg hover:shadow-2xl transition border-t-4 border-orange-500 group">
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center feature-icon group-hover:scale-110 transition">
                    <i class="fas fa-network-wired text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2 text-center">Sistem Informasi</h4>
                <p class="text-gray-600 text-sm text-center">Mengelola informasi untuk keputusan bisnis yang tepat</p>
            </div>
            
            <div class="glass-card p-8 rounded-xl shadow-lg hover:shadow-2xl transition border-t-4 border-orange-500 group">
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center feature-icon group-hover:scale-110 transition">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2 text-center">Manajemen Informatika</h4>
                <p class="text-gray-600 text-sm text-center">Perpaduan teknologi dan manajemen bisnis modern</p>
            </div>
        </div>
    </div>
</section>

<!-- Kontak -->
<section id="kontak" class="py-20 bg-gradient-to-br from-orange-50 to-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Hubungi Kami</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-orange-500 to-orange-600 mx-auto"></div>
        </div>
        
        <div class="max-w-4xl mx-auto grid md:grid-cols-3 gap-6">
            <div class="glass-card p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Alamat</h4>
                <p class="text-gray-600 text-sm">{{ Str::limit($pengaturan->alamat ?? 'Cimahi, Jawa Barat', 50) }}</p>
            </div>
            
            <div class="glass-card p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-phone text-white text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Telepon</h4>
                <p class="text-gray-600 text-sm">{{ $pengaturan->telepon ?? '0221234567' }}</p>
            </div>
            
            <div class="glass-card p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center feature-icon">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Email</h4>
                <p class="text-gray-600 text-sm">{{ $pengaturan->email ?? 'info@stmik.ac.id' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-10">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-center md:text-left">
                <h3 class="font-bold text-lg mb-2">{{ $pengaturan->nama_pesantren ?? 'STMIK Mardira Indonesia' }}</h3>
                <p class="text-gray-400 text-sm">&copy; 2025 All rights reserved.</p>
            </div>
            <div class="flex gap-3">
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600 rounded-full flex items-center justify-center transition">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600 rounded-full flex items-center justify-center transition">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-600 rounded-full flex items-center justify-center transition">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
@endsection

@section('scripts')
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
    });
});
@endsection