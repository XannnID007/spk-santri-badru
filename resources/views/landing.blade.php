@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
    <style>
        :root {
            --brand-orange: #f47200;
            --brand-navy: #0f172a;
        }

        /* Navbar Glass Transparent Black */
        .glass-nav {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 100;
        }

        .nav-logo-img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        /* Hero Section dengan Carousel */
        .hero-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #000;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-media-container {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide img,
        .hero-slide video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Overlay dengan gradien yang lebih elegan */
        .dark-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right,
                    rgba(0, 0, 0, 0.85) 0%,
                    rgba(0, 0, 0, 0.6) 50%,
                    rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        /* Konten Hero - ukuran lebih proporsional */
        .hero-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fb923c;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            color: #ffffff !important;
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-desc {
            color: #cbd5e1 !important;
            font-size: 0.95rem;
            line-height: 1.6;
            max-width: 550px;
            margin-bottom: 2rem;
        }

        /* Tombol Hero - ukuran lebih kecil */
        .btn-hero {
            background: var(--brand-orange);
            color: white !important;
            padding: 0.7rem 1.8rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-hero:hover {
            transform: scale(1.05);
            background: #ff8c00;
            box-shadow: 0 10px 30px rgba(244, 114, 0, 0.3);
        }

        .btn-hero-outline {
            padding: 0.7rem 1.8rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white !important;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Stats dengan ukuran lebih kecil */
        .hero-stats {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            gap: 2rem;
        }

        .stat-item h3 {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
        }

        .stat-item p {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-top: 0.25rem;
        }

        /* Section Alur - Design inovatif dengan timeline */
        .timeline-container {
            position: relative;
            padding: 3rem 0;
        }

        .timeline-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(to right, #f47200, #ff8c00);
            transform: translateY(-50%);
            z-index: 0;
        }

        .timeline-step {
            position: relative;
            z-index: 1;
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #f1f5f9;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .timeline-step:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: var(--brand-orange);
            box-shadow: 0 25px 50px rgba(244, 114, 0, 0.15);
        }

        .timeline-number {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #f47200, #ff8c00);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(244, 114, 0, 0.3);
            position: relative;
        }

        .timeline-number::after {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border: 2px solid var(--brand-orange);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0;
            }
        }

        /* Section Program - Card interaktif dengan hover effect */
        .program-card {
            position: relative;
            border-radius: 2rem;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .program-card:hover {
            transform: translateY(-20px) scale(1.02);
        }

        .program-image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
            height: 350px;
        }

        .program-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .program-card:hover .program-image {
            transform: scale(1.15);
        }

        .program-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.3) 50%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            transition: all 0.5s ease;
        }

        .program-card:hover .program-overlay {
            background: linear-gradient(to top, rgba(244, 114, 0, 0.95) 0%, rgba(244, 114, 0, 0.7) 70%, transparent 100%);
        }

        .program-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            transform: translateY(0);
            transition: all 0.5s ease;
        }

        .program-desc {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            line-height: 1.6;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .program-card:hover .program-desc {
            opacity: 1;
            transform: translateY(0);
        }

        .program-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 3.5rem;
            height: 3.5rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: all 0.5s ease;
        }

        .program-card:hover .program-icon {
            background: white;
            color: var(--brand-orange);
            transform: rotate(360deg);
        }

        /* Section Kontak - Design modern dengan split layout */
        .contact-card {
            background: white;
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
        }

        .contact-card:hover {
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.12);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 1.25rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-item:hover {
            background: #fef3e7;
            transform: translateX(10px);
        }

        .contact-icon {
            width: 3.5rem;
            height: 3.5rem;
            background: linear-gradient(135deg, #f47200, #ff8c00);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .contact-form {
            background: linear-gradient(135deg, #f47200, #ff8c00);
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(244, 114, 0, 0.3);
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid transparent;
            border-radius: 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: white;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: white;
            color: var(--brand-orange);
            border: none;
            border-radius: 1rem;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Footer - Simpel dan clean */
        .footer-simple {
            background: #0f172a;
            padding: 3rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .footer-logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--brand-orange);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-link {
            color: #94a3b8;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--brand-orange);
        }

        .footer-copyright {
            text-align: center;
            color: #475569;
            font-size: 0.85rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Carousel Navigation Dots */
        .carousel-dots {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.75rem;
            z-index: 20;
        }

        .carousel-dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: var(--brand-orange);
            width: 2rem;
            border-radius: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .timeline-line {
                display: none;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <nav class="glass-nav fixed w-full">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-20">
            <div class="flex items-center space-x-3">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="nav-logo-img">
                @else
                    <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                @endif
                <div class="hidden md:block">
                    <span
                        class="text-white font-extrabold text-base block leading-none uppercase">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                    <span class="text-[9px] text-orange-400 font-bold tracking-widest uppercase mt-1 block">Portal Seleksi
                        Digital</span>
                </div>
            </div>

            <div class="hidden lg:flex items-center space-x-8">
                <a href="#alur" class="text-sm font-semibold text-gray-300 hover:text-white transition">Alur</a>
                <a href="#program" class="text-sm font-semibold text-gray-300 hover:text-white transition">Program</a>
                <a href="#kontak" class="text-sm font-semibold text-gray-300 hover:text-white transition">Kontak</a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pendaftar.dashboard') }}"
                        class="btn-hero">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-white hover:text-orange-400 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-hero">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <section id="beranda" class="hero-wrapper">
        <div class="hero-media-container">
            @if (isset($banners) && $banners->count() > 0)
                @foreach ($banners as $index => $banner)
                    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                        @if ($banner->tipe === 'video')
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="{{ asset('storage/' . $banner->file) }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $banner->file) }}" class="w-full h-full object-cover"
                                alt="{{ $banner->judul }}">
                        @endif
                    </div>
                @endforeach
            @else
                <div class="hero-slide active">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600"
                        class="w-full h-full object-cover" alt="Default">
                </div>
            @endif
        </div>
        <div class="dark-overlay"></div>

        @if (isset($banners) && $banners->count() > 1)
            <div class="carousel-dots">
                @foreach ($banners as $index => $banner)
                    <div class="carousel-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div>
        @endif

        <div class="hero-content">
            <div class="reveal active">
                <span class="hero-badge">
                    Pendaftaran Santri Baru {{ date('Y') }}
                </span>
                <h1 class="hero-title">
                    Membangun Generasi Rabbani<br>
                    Melalui Seleksi <span class="text-orange-500">Objektif & Digital</span>
                </h1>
                <p class="hero-desc">
                    Wujudkan pendidikan terbaik dengan sistem pendaftaran transparan dan akurat menggunakan metode SMART
                    untuk menjaring calon santri unggulan.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn-hero">
                        Daftar Sekarang
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#alur" class="btn-hero-outline">
                        Lihat Mekanisme
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>{{ $pengaturan->jumlah_santri ?? '0' }}+</h3>
                        <p>Santri Aktif</p>
                    </div>
                    <div class="stat-item">
                        <h3>{{ $pengaturan->jumlah_guru ?? '0' }}</h3>
                        <p>Pengajar</p>
                    </div>
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Transparan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-24 bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-slate-900 text-4xl font-black mb-4">Alur Pendaftaran</h2>
                <p class="text-slate-600">Empat langkah mudah untuk bergabung menjadi bagian dari kami</p>
            </div>

            <div class="timeline-container">
                <div class="timeline-line hidden md:block"></div>
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="timeline-step">
                        <div class="timeline-number">1</div>
                        <h3 class="text-slate-900 text-xl font-bold mb-3 text-center">Registrasi</h3>
                        <p class="text-sm text-slate-600 text-center leading-relaxed">
                            Buat akun pendaftar menggunakan email aktif melalui portal resmi
                        </p>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-number">2</div>
                        <h3 class="text-slate-900 text-xl font-bold mb-3 text-center">Data Profil</h3>
                        <p class="text-sm text-slate-600 text-center leading-relaxed">
                            Lengkapi identitas diri dan unggah berkas persyaratan digital
                        </p>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-number">3</div>
                        <h3 class="text-slate-900 text-xl font-bold mb-3 text-center">Ujian Tes</h3>
                        <p class="text-sm text-slate-600 text-center leading-relaxed">
                            Ikuti rangkaian ujian akademik dan wawancara sesuai jadwal
                        </p>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-number">4</div>
                        <h3 class="text-slate-900 text-xl font-bold mb-3 text-center">Hasil Seleksi</h3>
                        <p class="text-sm text-slate-600 text-center leading-relaxed">
                            Pengumuman kelulusan objektif berdasarkan perangkingan SMART
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-xl">
                    <h2 class="text-slate-900 text-4xl font-black mb-4">Program Unggulan</h2>
                    <p class="text-slate-600">Integrasi ilmu syar'i dan kompetensi teknologi untuk generasi masa depan</p>
                </div>
                <a href="#"
                    class="text-sm font-bold text-orange-600 hover:text-orange-700 transition flex items-center gap-2">
                    Semua Program
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600" class="program-image"
                            alt="Tahfidz Quran">
                        <div class="program-icon">
                            <i class="fas fa-quran"></i>
                        </div>
                        <div class="program-overlay">
                            <h3 class="program-title">Tahfidz Quran</h3>
                            <p class="program-desc">
                                Metode menghafal intensif dengan target capaian yang terukur setiap semester
                            </p>
                        </div>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600" class="program-image"
                            alt="Literasi Digital">
                        <div class="program-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="program-overlay">
                            <h3 class="program-title">Literasi Digital</h3>
                            <p class="program-desc">
                                Penguasaan desain grafis, multimedia, dan dasar pemrograman komputer
                            </p>
                        </div>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600"
                            class="program-image" alt="Bahasa Global">
                        <div class="program-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="program-overlay">
                            <h3 class="program-title">Bahasa Global</h3>
                            <p class="program-desc">
                                Penerapan komunikasi aktif Bahasa Arab dan Inggris sebagai bekal dakwah global
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-24 bg-gradient-to-br from-slate-50 to-orange-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-slate-900 text-4xl font-black mb-6">
                        Hubungi Layanan<br>Informasi
                    </h2>
                    <p class="text-slate-600 mb-10">
                        Admin kami siap melayani pertanyaan seputar prosedur seleksi santri baru
                    </p>

                    <div class="space-y-6">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">WhatsApp</p>
                                <p class="text-lg font-bold text-slate-800">{{ $pengaturan->telepon ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Email Support</p>
                                <p class="text-lg font-bold text-slate-800">{{ $pengaturan->email ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Alamat</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $pengaturan->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h3 class="text-2xl font-bold text-white mb-6">Kirim Pesan</h3>
                    <form class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" placeholder="Nama Lengkap" class="form-input">
                            <input type="email" placeholder="Email" class="form-input">
                        </div>
                        <input type="text" placeholder="Subjek" class="form-input">
                        <textarea rows="4" placeholder="Pesan Anda..." class="form-input"></textarea>
                        <button type="submit" class="btn-submit">
                            Kirim Pesan
                            <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-simple">
        <div class="max-w-7xl mx-auto px-6">
            <div class="footer-content">
                <div class="footer-logo">
                    <div class="footer-logo-icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <div>
                        <span
                            class="text-white font-bold text-lg block">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                        <span class="text-slate-400 text-xs">Portal Seleksi Digital</span>
                    </div>
                </div>

                <div class="footer-links">
                    <a href="#beranda" class="footer-link">Beranda</a>
                    <a href="#alur" class="footer-link">Alur</a>
                    <a href="#program" class="footer-link">Program</a>
                    <a href="#kontak" class="footer-link">Kontak</a>
                    <a href="{{ route('login') }}" class="footer-link">Login</a>
                </div>

                <div class="flex gap-4">
                    <a href="#"
                        class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:bg-orange-500 hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:bg-orange-500 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:bg-orange-500 hover:text-white transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="footer-copyright">
                &copy; {{ date('Y') }} {{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}. All Rights Reserved.
            </div>
        </div>
    </footer>
@endsection

@section('scripts')
    <script>
        // Hero Carousel dengan support untuk video
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentSlide = 0;
        const slideCount = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[index].classList.add('active');
            if (dots[index]) dots[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slideCount;
            showSlide(currentSlide);
        }

        // Auto-play carousel setiap 5 detik
        if (slideCount > 1) {
            setInterval(nextSlide, 5000);
        }

        // Manual navigation via dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Smooth scroll untuk navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endsection
