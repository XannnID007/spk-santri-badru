@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
    <style>
        :root {
            --brand-orange: #f47200;
            --brand-navy: #0f172a;
        }

        /* --- NAVBAR --- */
        .glass-nav {
            background: transparent !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border-bottom: 1px solid transparent;
            z-index: 100;
            transition: all 0.4s ease;
        }

        .glass-nav.scrolled {
            background: rgba(20, 20, 20, 0.603) !important;
            backdrop-filter: blur(8px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-logo-img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        /* --- HERO SECTION --- */
        .hero-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #000;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-text-container {
            max-width: 800px;
            position: relative;
            z-index: 10;
            transform: translateY(-30px);
            /* Efek 'agak keatas' */
        }

        .hero-media-container,
        .hero-slide,
        .dark-overlay {
            position: absolute;
            inset: 0;
        }

        .hero-slide {
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
            background: linear-gradient(to right, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.5) 60%, rgba(0, 0, 0, 0.3) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .hero-title {
            color: #ffffff !important;
            font-size: clamp(1.5rem, 4vw, 4rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        /* Garis Pemisah setelah Button */
        .hero-divider {
            width: 100%;
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
            /* Garis tipis transparan */
            margin: 3rem 0;
            /* Jarak atas bawah */
        }

        .btn-hero {
            background: var(--brand-orange);
            color: white !important;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .hero-stats-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            /* Rata kiri */
            flex-wrap: wrap;
            /* Agar aman di layar kecil */
        }

        .stat-item-clean {
            display: flex;
            align-items: center;
            gap: 1rem;
            /* Jarak Icon ke Text */
            padding-right: 2.5rem;
            /* Jarak ke border kanan */
            margin-right: 2.5rem;
            /* Jarak ke item sebelah */
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            /* Garis pemisah */
        }

        /* Hapus border pada item terakhir */
        .stat-item-clean:last-child {
            border-right: none;
            padding-right: 0;
            margin-right: 0;
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--brand-orange);
            opacity: 0.9;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0.2rem;
        }

        /* --- GLOBAL SECTION TITLE --- */
        .section-title-line {
            font-size: 2rem;
            font-weight: 800;
            color: var(--brand-navy);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title-line::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--brand-orange);
            border-radius: 2px;
        }

        /* --- ABOUT FRAME --- */
        .about-frame {
            position: relative;
            width: 260px;
            height: 320px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 15px 15px 0px rgba(244, 114, 0, 0.1);
            margin: 0 auto;
        }

        .about-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* --- ALUR SECTION --- */
        .timeline-wrapper {
            position: relative;
            padding-left: 20px;
            border-left: 2px solid #e2e8f0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 5px;
            width: 14px;
            height: 14px;
            background: white;
            border: 3px solid var(--brand-orange);
            border-radius: 50%;
        }

        /* --- PROGRAM SECTION --- */
        .program-img-card {
            position: relative;
            height: 220px;
            border-radius: 16px;
            overflow: hidden;
            group: cursor-pointer;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .program-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .program-img-card:hover img {
            transform: scale(1.1);
        }

        .program-overlay-grad {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.3) 50%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }

        /* --- CONTACT SECTION --- */
        .contact-list-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .contact-list-item:hover {
            transform: translateX(5px);
            border-color: var(--brand-orange);
            box-shadow: 0 10px 20px rgba(244, 114, 0, 0.05);
        }

        .contact-icon-box {
            width: 40px;
            height: 40px;
            background: #fff7ed;
            color: var(--brand-orange);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        /* --- FOOTER MAP --- */
        .footer-map-box {
            width: 100%;
            height: 140px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: white;
        }

        .footer-map-box iframe {
            filter: invert(0);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {

            .hero-text-container {
                text-align: center;
                transform: translateY(0);
                /* Reset posisi di mobile */
            }

            .hero-stats-row {
                justify-content: center;
                gap: 2rem;
            }

            .stat-item-clean {
                flex-direction: column;
                /* Stack vertikal di mobile */
                border-right: none;
                /* Hapus garis pemisah di mobile */
                padding-right: 0;
                margin-right: 0;
            }

            .hero-divider {
                margin: 2rem 0;
            }

            .hero-content {
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <nav class="glass-nav fixed w-full top-0 left-0">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-20">
            <div class="flex items-center space-x-3">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="nav-logo-img">
                @else
                    <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                @endif
                <div class="hidden md:block">
                    <span
                        class="text-white font-extrabold text-lg block leading-none uppercase">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                </div>
            </div>

            <div class="hidden lg:flex items-center space-x-8">
                <a href="#tentang"
                    class="text-xs font-bold text-gray-300 hover:text-white uppercase tracking-wider transition">Tentang</a>
                <a href="#alur"
                    class="text-xs font-bold text-gray-300 hover:text-white uppercase tracking-wider transition">Alur</a>
                <a href="#program"
                    class="text-xs font-bold text-gray-300 hover:text-white uppercase tracking-wider transition">Program</a>
                <a href="#kontak"
                    class="text-xs font-bold text-gray-300 hover:text-white uppercase tracking-wider transition">Hubungi</a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pendaftar.dashboard') }}"
                        class="btn-hero text-xs">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-bold text-white hover:text-orange-400 uppercase tracking-wider transition">Masuk</a>
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
                            <video autoplay muted loop playsinline>
                                <source src="{{ asset('storage/' . $banner->file) }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $banner->file) }}" alt="{{ $banner->judul }}">
                        @endif
                    </div>
                @endforeach
            @else
                <div class="hero-slide active"><img
                        src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600" alt="Default"></div>
            @endif
        </div>
        <div class="dark-overlay"></div>

        <div class="max-w-7xl mx-auto px-6 w-full relative z-10">
            <div class="hero-text-container reveal active">

                <span class="text-orange-400 font-bold tracking-[0.2em] text-xs uppercase mb-4 block">
                    Penerimaan Santri Baru {{ date('Y') }}
                </span>

                <h1 class="hero-title">
                    Membangun Akhlak,<br>
                    Meraih Prestasi.
                </h1>

                <p class="text-slate-300 text-base md:text-lg leading-relaxed mb-8 max-w-2xl">
                    Bergabunglah bersama kami di Pondok Pesantren {{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}.
                    Lingkungan pendidikan yang kondusif untuk mencetak generasi rabbani yang unggul dalam IMTAQ dan IPTEK.
                </p>

                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <a href="{{ route('register') }}" class="btn-hero shadow-lg shadow-orange-500/20">
                        Daftar Sekarang
                    </a>
                    <a href="#alur"
                        class="px-7 py-3 rounded-full border border-white/30 text-white font-bold text-sm hover:bg-white hover:text-black transition">
                        Info Selengkapnya
                    </a>
                </div>

                <div class="hero-divider"></div>

                <div class="hero-stats-row">
                    <div class="stat-item-clean">
                        <i class="fas fa-users stat-icon"></i>
                        <div class="stat-info">
                            <span class="stat-number">{{ $pengaturan->jumlah_santri ?? '500' }}+</span>
                            <span class="stat-label">Santri Mukim</span>
                        </div>
                    </div>

                    <div class="stat-item-clean">
                        <i class="fas fa-chalkboard-teacher stat-icon"></i>
                        <div class="stat-info">
                            <span class="stat-number">{{ $pengaturan->jumlah_guru ?? '45' }}</span>
                            <span class="stat-label">Guru & Staff</span>
                        </div>
                    </div>

                    <div class="stat-item-clean">
                        <i class="fas fa-graduation-cap stat-icon"></i>
                        <div class="stat-info">
                            <span class="stat-number">{{ $pengaturan->jumlah_alumni ?? '1k' }}+</span>
                            <span class="stat-label">Alumni</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="tentang" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <h2 class="section-title-line">Tentang Al - Badru</h2>
                    <p class="text-slate-600 leading-relaxed mb-4 text-justify">
                        Berdiri sejak tahun 2010, Pondok Pesantren Al-Badru berkomitmen untuk menjadi lembaga pendidikan
                        Islam terdepan. Kami memadukan nilai-nilai salaf dengan manajemen modern.
                    </p>
                    <p class="text-slate-600 leading-relaxed mb-6 text-justify">
                        Dengan fasilitas yang memadai dan lingkungan yang asri, Al-Badru menjadi rumah kedua yang nyaman
                        bagi para penuntut ilmu.
                    </p>
                    <div class="flex gap-8">
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">Visi</h4>
                            <p class="text-sm text-slate-500">Mewujudkan Generasi Qurani</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">Misi</h4>
                            <p class="text-sm text-slate-500">Pendidikan Berbasis Adab</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end reveal delay-100">
                    <div class="about-frame">
                        <img src="images/pimpinan.jpeg" alt="Pimpinan Pondok">
                        <div
                            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-center">
                            <h4 class="text-white font-bold text-sm">Pimpinan Pondok</h4>
                            <span class="text-orange-400 text-xs uppercase tracking-wide"><i>KH. Cucun Suntani</i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-24 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-12 gap-12">
                <div class="md:col-span-5 reveal">
                    <h2 class="section-title-line">Tahapan Seleksi</h2>
                    <div class="timeline-wrapper mt-4">
                        <div class="timeline-item">
                            <h4 class="font-bold text-slate-800">Registrasi Online</h4>
                            <p class="text-xs text-slate-500 mt-1">Buat akun & isi formulir</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-slate-800">Upload Berkas</h4>
                            <p class="text-xs text-slate-500 mt-1">KK, Akta, & Foto</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-slate-800">Ujian Seleksi</h4>
                            <p class="text-xs text-slate-500 mt-1">Tes Tulis & Wawancara</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-slate-800">Pengumuman</h4>
                            <p class="text-xs text-slate-500 mt-1">Hasil kelulusan</p>
                        </div>
                    </div>
                </div>

                <div
                    class="md:col-span-7 reveal delay-100 bg-white p-8 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-center">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Mudahnya Mendaftar di Al-Badru</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Kami merancang sistem pendaftaran digital yang efisien agar orang tua dan calon santri dapat
                        melakukan proses pendaftaran dari mana saja. Sistem kami transparan, akuntabel, dan memudahkan Anda
                        memantau status kelulusan secara <em>real-time</em>.
                    </p>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Persiapkan berkas digital Anda sekarang dan bergabunglah menjadi bagian dari keluarga besar kami.
                    </p>
                    <div>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center text-orange-600 font-bold hover:underline">
                            Buat Akun Pendaftaran <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-10 reveal">
                <h2 class="section-title-line">Program Pendidikan</h2>
                <p class="text-slate-500 max-w-lg">Program unggulan yang dirancang untuk kebutuhan santri masa kini.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="program-img-card reveal group">
                    <img src="https://images.unsplash.com/photo-1584286595398-a59f21d313f5?w=600&q=80" alt="Tahfidz">
                    <div class="program-overlay-grad">
                        <h3 class="text-white text-lg font-bold mb-1">Tahfidz Quran</h3>
                        <p class="text-slate-300 text-xs">Menghafal 30 Juz Mutqin</p>
                    </div>
                </div>

                <div class="program-img-card reveal group delay-100">
                    <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?w=600&q=80" alt="Kitab Kuning">
                    <div class="program-overlay-grad">
                        <h3 class="text-white text-lg font-bold mb-1">Kitab Kuning</h3>
                        <p class="text-slate-300 text-xs">Kajian Turats Islami</p>
                    </div>
                </div>

                <div class="program-img-card reveal group delay-200">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80"
                        alt="Sekolah Gratis">
                    <div class="program-overlay-grad">
                        <h3 class="text-white text-lg font-bold mb-1">Sekolah Gratis</h3>
                        <p class="text-slate-300 text-xs">Beasiswa Pendidikan 100%</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-24 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-start">
                <div class="reveal">
                    <h2 class="section-title-line">Hubungi Kami</h2>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Jika Anda memiliki pertanyaan seputar pendaftaran, kurikulum, atau ingin berkunjung langsung ke
                        lokasi pondok, jangan ragu untuk menghubungi kami melalui kontak yang tersedia.
                    </p>
                    <a href="https://wa.me/{{ $pengaturan->telepon ?? '' }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-full font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-600/20">
                        <i class="fab fa-whatsapp text-lg"></i> Chat WhatsApp
                    </a>
                </div>

                <div class="reveal delay-100">
                    <div class="contact-list-item">
                        <div class="contact-icon-box"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">Telepon / WhatsApp</p>
                            <p class="text-slate-900 font-medium">{{ $pengaturan->telepon ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="contact-list-item">
                        <div class="contact-icon-box"><i class="fas fa-envelope"></i></div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">Email Resmi</p>
                            <p class="text-slate-900 font-medium">{{ $pengaturan->email ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="contact-list-item">
                        <div class="contact-icon-box"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">Alamat Lengkap</p>
                            <p class="text-slate-900 font-medium text-sm leading-snug">{{ $pengaturan->alamat ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black pt-16 pb-8 border-t border-white/10">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-y-10 md:gap-x-6 mb-12">

                <div class="md:col-span-4">
                    <div class="flex items-center space-x-2 mb-4">
                        @if ($pengaturan && $pengaturan->logo)
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo"
                                class="h-8 w-auto object-contain">
                        @else
                            <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                        @endif
                        <span
                            class="text-white font-extrabold text-sm uppercase">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                    </div>
                    <p class="text-slate-500 text-xs leading-relaxed max-w-xs">
                        Mewujudkan pendidikan Islam yang berkualitas, modern, dan beradab untuk generasi masa depan.
                    </p>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-white font-bold text-sm mb-4">Menu</h4>
                    <ul class="space-y-2 text-xs text-slate-500">
                        <li><a href="#tentang" class="hover:text-orange-500 transition">Tentang</a></li>
                        <li><a href="#alur" class="hover:text-orange-500 transition">Alur Pendaftaran</a></li>
                        <li><a href="#program" class="hover:text-orange-500 transition">Program</a></li>
                    </ul>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-white font-bold text-sm mb-4">Sosial Media</h4>
                    <div class="flex gap-2">
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-slate-400 hover:bg-orange-600 hover:text-white transition text-xs"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-slate-400 hover:bg-pink-600 hover:text-white transition text-xs"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#"
                            class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:text-white transition text-xs"><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="md:col-span-4">
                    <h4 class="text-white font-bold text-sm mb-4">Peta Lokasi</h4>
                    <div class="footer-map-box">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.833983273183!2d107.61678231477286!3d-6.910444994999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c5e88662f%3A0x750eb266d8a6473!2sGedung%20Sate!5e0!3m2!1sid!2sid!4v1629876543210!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/10 text-center text-slate-600 text-[10px]">
                © {{ date('Y') }} {{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}. All Rights Reserved.
            </div>
        </div>
    </footer>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar Scroll Logic
            const navbar = document.querySelector('.glass-nav');

            function handleScroll() {
                if (window.scrollY > 80) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            window.addEventListener('scroll', handleScroll);
            handleScroll();

            // Carousel Logic
            const slides = document.querySelectorAll('.hero-slide');
            if (slides.length > 0) {
                let currentSlide = 0;
                setInterval(() => {
                    slides[currentSlide].classList.remove('active');
                    currentSlide = (currentSlide + 1) % slides.length;
                    slides[currentSlide].classList.add('active');
                }, 5000);
            }
        });
    </script>
@endsection
