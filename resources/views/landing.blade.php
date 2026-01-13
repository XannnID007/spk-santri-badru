@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
    <style>
        :root {
            --brand-orange: #f47200;
            --brand-navy: #0f172a;
        }

        /* --- NAVBAR STYLES (ABU TRANSPARAN) --- */
        .glass-nav {
            background: transparent !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border-bottom: 1px solid transparent;
            z-index: 100;
            transition: background 0.4s ease, backdrop-filter 0.4s ease, box-shadow 0.4s ease;
        }

        .glass-nav.scrolled {
            /* REVISI: Warna Abu-abu Gelap Transparan */
            background: rgba(30, 30, 30, 0.85) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .nav-logo-img {
            height: 36px;
            /* Diperkecil sedikit */
            width: auto;
            object-fit: contain;
        }

        /* --- HERO SECTION STYLES --- */
        .hero-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #000;
            overflow: hidden;
            padding-top: 70px;
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

        .dark-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1100px;
            /* Max width diperkecil */
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .hero-title {
            color: #ffffff !important;
            /* REVISI: Ukuran font diperkecil */
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.25rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .btn-hero {
            background: var(--brand-orange);
            color: white !important;
            padding: 0.6rem 1.5rem;
            /* Padding tombol diperkecil */
            border-radius: 50px;
            font-size: 0.9rem;
            /* Font tombol diperkecil */
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 114, 0, 0.4);
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            background: #ff8c00;
            box-shadow: 0 8px 25px rgba(244, 114, 0, 0.6);
        }

        .btn-hero-outline {
            padding: 0.6rem 1.5rem;
            /* Padding tombol diperkecil */
            border-radius: 50px;
            font-size: 0.9rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white !important;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-hero-outline:hover {
            background: white;
            color: #333 !important;
            border-color: white;
        }

        /* --- ALUR TIMELINE STYLES (COMPACT VERSION) --- */
        .timeline-section {
            background-color: #f8fafc;
            position: relative;
            overflow: hidden;
        }

        .timeline-vertical-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 3px;
            /* Garis lebih tipis */
            background: #e2e8f0;
            transform: translateX(-50%);
            z-index: 0;
        }

        .timeline-row {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 3rem;
            /* Jarak antar row diperkecil */
            position: relative;
            z-index: 1;
        }

        .timeline-content-wrapper {
            width: 50%;
            display: flex;
            position: relative;
        }

        .timeline-row:nth-child(odd) .timeline-content-wrapper {
            justify-content: flex-end;
            padding-right: 2.5rem;
            /* Padding ke garis diperkecil */
            margin-right: 50%;
        }

        .timeline-row:nth-child(even) .timeline-content-wrapper {
            justify-content: flex-start;
            padding-left: 2.5rem;
            /* Padding ke garis diperkecil */
            margin-left: 50%;
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 16px;
            /* Dot diperkecil */
            height: 16px;
            background: var(--brand-orange);
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(244, 114, 0, 0.2);
            z-index: 2;
        }

        .timeline-card {
            background: white;
            padding: 1.5rem;
            /* REVISI: Padding card diperkecil */
            border-radius: 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            max-width: 380px;
            /* REVISI: Lebar card diperkecil */
            width: 100%;
            position: relative;
            transition: all 0.4s ease;
            border-left: 4px solid var(--brand-orange);
        }

        .timeline-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .timeline-step-num {
            font-size: 2.5rem;
            /* REVISI: Angka diperkecil */
            font-weight: 900;
            color: #f1f5f9;
            position: absolute;
            top: 0.5rem;
            right: 1rem;
            line-height: 1;
            z-index: 0;
        }

        .timeline-info {
            position: relative;
            z-index: 1;
        }

        /* --- PROGRAM STYLES (COMPACT) --- */
        .program-modern-card {
            background: white;
            border-radius: 16px;
            /* Radius diperkecil */
            padding: 1.75rem 1.5rem;
            /* REVISI: Padding diperkecil */
            border: 1px solid #f1f5f9;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: 100%;
        }

        .program-modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--brand-orange);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .program-modern-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-8px);
        }

        .program-modern-card:hover::before {
            transform: scaleX(1);
        }

        .program-icon-box {
            width: 48px;
            /* REVISI: Icon box diperkecil */
            height: 48px;
            background: #fff7ed;
            color: var(--brand-orange);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.4s ease;
        }

        .program-modern-card:hover .program-icon-box {
            background: var(--brand-orange);
            color: white;
            transform: rotate(10deg);
        }

        /* --- CONTACT STYLES (COMPACT) --- */
        .contact-action-card {
            background: white;
            border-radius: 16px;
            padding: 2rem 1.5rem;
            /* REVISI: Padding diperkecil */
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .contact-action-card:hover {
            transform: scale(1.03);
            border-color: var(--brand-orange);
            box-shadow: 0 15px 30px rgba(244, 114, 0, 0.15);
        }

        .contact-big-icon {
            width: 60px;
            /* REVISI: Icon diperkecil */
            height: 60px;
            background: #f8fafc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #334155;
            margin-bottom: 1rem;
            transition: all 0.4s ease;
        }

        .contact-action-card:hover .contact-big-icon {
            background: var(--brand-orange);
            color: white;
        }

        /* --- RESPONSIVE ADJUSTMENTS --- */
        @media (max-width: 768px) {
            .timeline-vertical-line {
                left: 20px;
            }

            .timeline-row {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 2rem;
            }

            .timeline-row:nth-child(odd) .timeline-content-wrapper,
            .timeline-row:nth-child(even) .timeline-content-wrapper {
                width: 100%;
                margin: 0;
                padding: 0 0 0 45px;
                justify-content: flex-start;
            }

            .timeline-dot {
                left: 20px;
            }

            .timeline-card {
                width: 100%;
                max-width: 100%;
                padding: 1.25rem;
            }

            .hero-title {
                font-size: 2.2rem;
            }
        }
    </style>
@endsection

@section('content')
    <nav class="glass-nav fixed w-full top-0 left-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="nav-logo-img">
                @else
                    <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                @endif
                <div class="hidden md:block">
                    <span
                        class="text-white font-extrabold text-sm block leading-none uppercase">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                    <span class="text-[9px] text-orange-400 font-bold tracking-widest uppercase mt-0.5 block">Portal Seleksi
                        Digital</span>
                </div>
            </div>

            <div class="hidden lg:flex items-center space-x-6"> <a href="#alur"
                    class="text-xs font-semibold text-gray-300 hover:text-white transition uppercase tracking-wide">Alur</a>
                <a href="#program"
                    class="text-xs font-semibold text-gray-300 hover:text-white transition uppercase tracking-wide">Program</a>
                <a href="#kontak"
                    class="text-xs font-semibold text-gray-300 hover:text-white transition uppercase tracking-wide">Hubungi</a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pendaftar.dashboard') }}"
                        class="btn-hero text-xs">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-semibold text-white hover:text-orange-400 transition uppercase tracking-wide">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-hero text-xs">Daftar</a>
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

        <div class="hero-content">
            <div class="reveal active text-center md:text-left">
                <div
                    class="inline-block px-3 py-1 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-400 text-[10px] font-bold tracking-widest uppercase mb-4 backdrop-blur-sm">
                    Penerimaan Santri Baru {{ date('Y') }}/{{ date('Y') + 1 }}
                </div>
                <h1 class="hero-title">
                    Pendidikan Adab <br>
                    & Teknologi Terdepan
                </h1>
                <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-xl mb-6 mx-auto md:mx-0">
                    Bergabunglah bersama kami untuk mencetak generasi Qurani yang tidak hanya hafal Al-Qur'an,
                    tetapi juga menguasai sains dan teknologi masa depan.
                </p>
                <div class="flex flex-col md:flex-row gap-3 justify-center md:justify-start">
                    <a href="{{ route('register') }}" class="btn-hero justify-center">
                        Daftar Sekarang
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                    <a href="#alur" class="btn-hero-outline justify-center">
                        Pelajari Alur
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-16 timeline-section">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                <h2 class="text-slate-900 text-3xl font-black mb-3">Alur Pendaftaran</h2>
                <p class="text-slate-600 text-sm md:text-base">Ikuti langkah mudah berikut untuk menjadi bagian dari
                    keluarga besar kami.</p>
            </div>

            <div class="relative">
                <div class="timeline-vertical-line"></div>

                <div class="timeline-row reveal">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content-wrapper">
                        <div class="timeline-card">
                            <div class="timeline-step-num">01</div>
                            <div class="timeline-info">
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Registrasi Akun</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Buat akun pada portal resmi menggunakan email aktif.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-row reveal">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content-wrapper">
                        <div class="timeline-card">
                            <div class="timeline-step-num">02</div>
                            <div class="timeline-info">
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Lengkapi Biodata</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Isi formulir data diri dan upload berkas persyaratan digital.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-row reveal">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content-wrapper">
                        <div class="timeline-card">
                            <div class="timeline-step-num">03</div>
                            <div class="timeline-info">
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Ujian Seleksi</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Ikuti tes akademik dan wawancara sesuai jadwal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="timeline-row reveal">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content-wrapper">
                        <div class="timeline-card">
                            <div class="timeline-step-num">04</div>
                            <div class="timeline-info">
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Pengumuman</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Hasil seleksi diumumkan di portal. Lakukan daftar ulang jika lolos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="program" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4 reveal">
                <div>
                    <h2 class="text-slate-900 text-3xl font-black mb-2">Program Pendidikan</h2>
                    <p class="text-slate-600 text-sm">Kurikulum terintegrasi dunia dan akhirat.</p>
                </div>
                <a href="#"
                    class="group flex items-center gap-2 text-sm font-bold text-orange-600 hover:text-orange-700">
                    Selengkapnya
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="program-modern-card reveal">
                    <div class="program-icon-box">
                        <i class="fas fa-quran"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Tahfidz Intensif</h3>
                    <p class="text-slate-600 text-sm mb-4 flex-grow">
                        Program unggulan menghafal Al-Qur'an 30 Juz dengan metode mutqin.
                    </p>
                    <ul class="space-y-1.5 w-full">
                        <li class="flex items-center text-xs text-slate-500">
                            <i class="fas fa-check text-green-500 mr-2"></i> Target 30 Juz
                        </li>
                        <li class="flex items-center text-xs text-slate-500">
                            <i class="fas fa-check text-green-500 mr-2"></i> Sertifikat Sanad
                        </li>
                    </ul>
                </div>

                <div class="program-modern-card reveal">
                    <div class="program-icon-box">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">IT & Coding</h3>
                    <p class="text-slate-600 text-sm mb-4 flex-grow">
                        Pembekalan skill Web Development, Desain Grafis, dan dasar AI.
                    </p>
                    <ul class="space-y-1.5 w-full">
                        <li class="flex items-center text-xs text-slate-500">
                            <i class="fas fa-check text-green-500 mr-2"></i> Fullstack Web
                        </li>
                        <li class="flex items-center text-xs text-slate-500">
                            <i class="fas fa-check text-green-500 mr-2"></i> Lab Komputer
                        </li>
                    </ul>
                </div>

                <div class="program-modern-card reveal">
                    <div class="program-icon-box">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Bahasa Asing</h3>
                    <p class="text-slate-600 text-sm mb-4 flex-grow">
                        Wajib berbahasa Arab dan Inggris dalam percakapan sehari-hari.
                    </p>
                    <ul class="space-y-1.5 w-full">
                        <li class="flex items-center text-xs text-slate-500">
                            <i class="fas fa-check text-green-500 mr-2"></i> Native Speaker
                        </li>
                        <li class="flex items-center text-xs text-slate-500">
                            <i class="fas fa-check text-green-500 mr-2"></i> Public Speaking
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-16 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-10 reveal">
                <span class="text-orange-600 font-bold tracking-wider uppercase text-xs mb-1 block">Pusat Bantuan</span>
                <h2 class="text-slate-900 text-3xl font-black mb-3">Hubungi Kami</h2>
                <p class="text-slate-600 text-sm">Tim kami siap membantu Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <a href="https://wa.me/{{ $pengaturan->telepon ?? '' }}" target="_blank"
                    class="contact-action-card reveal">
                    <div class="contact-big-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">WhatsApp</h3>
                    <p class="text-slate-500 mb-2 text-xs">Chat cepat dengan admin</p>
                    <span class="text-orange-600 font-bold text-sm">{{ $pengaturan->telepon ?? '0812-xxxx-xxxx' }}</span>
                </a>

                <a href="mailto:{{ $pengaturan->email ?? '' }}" class="contact-action-card reveal">
                    <div class="contact-big-icon">
                        <i class="far fa-envelope"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Email</h3>
                    <p class="text-slate-500 mb-2 text-xs">Pertanyaan formal</p>
                    <span
                        class="text-orange-600 font-bold text-sm">{{ $pengaturan->email ?? 'info@pesantren.com' }}</span>
                </a>

                <a href="#" class="contact-action-card reveal">
                    <div class="contact-big-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Lokasi</h3>
                    <p class="text-slate-500 mb-2 text-xs">Lihat peta</p>
                    <span
                        class="text-orange-600 font-bold text-xs px-2 line-clamp-1">{{ $pengaturan->alamat ?? 'Bandung, Indonesia' }}</span>
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-[#0f172a] pt-12 pb-6 border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-10">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        @if ($pengaturan && $pengaturan->logo)
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo"
                                class="h-8 w-auto object-contain">
                        @else
                            <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                        @endif
                        <div>
                            <span
                                class="text-white font-extrabold text-base block leading-none uppercase">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                            <span
                                class="text-[10px] text-slate-400 font-medium tracking-widest uppercase mt-0.5 block">Portal
                                Seleksi Digital</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Mewujudkan pendidikan Islam yang berkualitas, modern, dan beradab.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#beranda" class="text-slate-400 hover:text-orange-500 transition">Beranda</a></li>
                        <li><a href="#alur" class="text-slate-400 hover:text-orange-500 transition">Alur</a></li>
                        <li><a href="#program" class="text-slate-400 hover:text-orange-500 transition">Program</a></li>
                        <li><a href="{{ route('login') }}"
                                class="text-slate-400 hover:text-orange-500 transition">Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Sosial Media</h4>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-orange-600 hover:text-white transition-all">
                            <i class="fab fa-facebook-f text-xs"></i>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-pink-600 hover:text-white transition-all">
                            <i class="fab fa-instagram text-xs"></i>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:text-white transition-all">
                            <i class="fab fa-youtube text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-800 text-center text-slate-500 text-xs">
                &copy; {{ date('Y') }} {{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}. All Rights Reserved.
            </div>
        </div>
    </footer>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- LOGIC NAVBAR TRANSPARAN VS SCROLLED ---
            const navbar = document.querySelector('.glass-nav');

            function handleScroll() {
                const triggerPoint = window.innerHeight - 80;
                if (window.scrollY > triggerPoint) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }

            window.addEventListener('scroll', handleScroll);
            handleScroll();

            // --- CAROUSEL LOGIC ---
            const slides = document.querySelectorAll('.hero-slide');
            if (slides.length > 0) {
                let currentSlide = 0;
                const slideCount = slides.length;

                function nextSlide() {
                    slides[currentSlide].classList.remove('active');
                    currentSlide = (currentSlide + 1) % slideCount;
                    slides[currentSlide].classList.add('active');
                }

                if (slideCount > 1) {
                    setInterval(nextSlide, 5000);
                }
            }
        });
    </script>
@endsection
