@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
    <style>
        :root {
            --brand-orange: #f47200;
            --brand-navy: #0f172a;
        }

        /* Navbar Glass Dark */
        .glass-nav {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 100;
        }

        .nav-logo-img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        /* Hero Section - Posisi Pas */
        .hero-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-color: #000;
            overflow: hidden;
            padding-top: 80px;
            /* Jarak aman dari Navbar */
        }

        .hero-media {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        /* Overlay Gelap Sempurna */
        .dark-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right,
                    rgba(0, 0, 0, 0.8) 10%,
                    rgba(0, 0, 0, 0.5) 50%,
                    rgba(0, 0, 0, 0.3) 100%);
            z-index: 1;
        }

        /* Konten Hero (Wajib Putih karena Background Gelap) */
        .hero-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Ukuran Judul Pas: Menggunakan clamp agar proporsional di semua layar */
        .hero-title {
            color: #ffffff !important;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-desc {
            color: #cbd5e1 !important;
            font-size: 1.1rem;
            line-height: 1.7;
            max-width: 600px;
            margin-bottom: 3rem;
        }

        /* Tombol */
        .btn-brand {
            background: var(--brand-orange);
            color: white !important;
            padding: 0.9rem 2.2rem;
            border-radius: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            transform: scale(1.05);
            background: #ff8c00;
        }

        /* Card Section Bawah (Warna Teks Gelap Terjamin) */
        .card-modern {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 1.5rem;
            padding: 2.5rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-modern:hover {
            transform: translateY(-10px);
            border-color: var(--brand-orange);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .text-slate-900 {
            color: #0f172a !important;
        }

        .text-slate-600 {
            color: #475569 !important;
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
                <a href="#alur"
                    class="text-[10px] font-bold text-gray-400 hover:text-white uppercase tracking-widest transition">Alur</a>
                <a href="#program"
                    class="text-[10px] font-bold text-gray-400 hover:text-white uppercase tracking-widest transition">Program</a>
                <a href="#kontak"
                    class="text-[10px] font-bold text-gray-400 hover:text-white uppercase tracking-widest transition">Kontak</a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pendaftar.dashboard') }}"
                        class="btn-brand text-xs py-2 px-6">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-[10px] font-bold text-white uppercase tracking-widest mr-4 hover:text-orange-400">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-brand text-xs py-2 px-6">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <section id="beranda" class="hero-wrapper">
        <div class="hero-media">
            @if (isset($banners) && $banners->count() > 0)
                @php $banner = $banners->first(); @endphp
                @if ($banner->tipe === 'video')
                    <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                        <source src="{{ asset('storage/' . $banner->file) }}" type="video/mp4">
                    </video>
                @else
                    <img src="{{ asset('storage/' . $banner->file) }}" class="w-full h-full object-cover">
                @endif
            @else
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600"
                    class="w-full h-full object-cover">
            @endif
        </div>
        <div class="dark-overlay"></div>

        <div class="hero-content">
            <div class="reveal active"> <span
                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 text-orange-400 text-[10px] font-black uppercase tracking-[0.2em] mb-6 border border-white/20">
                    Pendaftaran Santri Baru {{ date('Y') }}
                </span>
                <h1 class="hero-title">Membangun Generasi Rabbani <br>Melalui Seleksi <span class="text-orange-500">Objektif
                        & Digital.</span></h1>
                <p class="hero-desc">
                    Wujudkan pendidikan terbaik dengan sistem pendaftaran transparan dan akurat menggunakan metode SMART
                    untuk menjaring calon santri unggulan.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="btn-brand text-lg">Daftar Sekarang <i
                            class="fas fa-arrow-right text-xs"></i></a>
                    <a href="#alur"
                        class="px-10 py-4 rounded-xl border border-white/20 text-white font-bold text-sm hover:bg-white/10 transition">Lihat
                        Mekanisme</a>
                </div>

                <div class="mt-16 pt-10 border-t border-white/10 flex gap-12 text-white">
                    <div>
                        <p class="text-3xl font-black">{{ $pengaturan->jumlah_santri ?? '0' }}+</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Santri Aktif</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black">{{ $pengaturan->jumlah_guru ?? '0' }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pengajar</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black">100%</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Transparan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-32 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20 reveal">
                <h2 class="text-slate-900 text-4xl font-black mb-4">Alur Pendaftaran</h2>
                <p class="text-slate-600">Empat langkah mudah untuk bergabung menjadi bagian dari kami.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="card-modern reveal text-center">
                    <div
                        class="w-14 h-14 bg-orange-500 text-white rounded-2xl flex items-center justify-center font-black text-xl mb-8 mx-auto shadow-lg">
                        1</div>
                    <h3 class="text-slate-900 text-xl font-bold mb-4">Registrasi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Buat akun pendaftar menggunakan email aktif melalui
                        portal resmi.</p>
                </div>
                <div class="card-modern reveal text-center">
                    <div
                        class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black text-xl mb-8 mx-auto">
                        2</div>
                    <h3 class="text-slate-900 text-xl font-bold mb-4">Data Profil</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Lengkapi identitas diri dan unggah berkas persyaratan
                        digital.</p>
                </div>
                <div class="card-modern reveal text-center">
                    <div
                        class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black text-xl mb-8 mx-auto">
                        3</div>
                    <h3 class="text-slate-900 text-xl font-bold mb-4">Ujian Tes</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Ikuti rangkaian ujian akademik dan wawancara sesuai
                        jadwal.</p>
                </div>
                <div class="card-modern reveal text-center">
                    <div
                        class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-black text-xl mb-8 mx-auto">
                        4</div>
                    <h3 class="text-slate-900 text-xl font-bold mb-4">Hasil Seleksi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Pengumuman kelulusan objektif berdasarkan perangkingan
                        SMART.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8 reveal">
                <div class="max-w-xl">
                    <h2 class="text-slate-900 text-4xl font-black mb-4">Program Unggulan</h2>
                    <p class="text-slate-600">Integrasi ilmu syar'i dan kompetensi teknologi untuk generasi masa depan.</p>
                </div>
                <a href="#" class="text-xs font-bold text-orange-600 uppercase tracking-widest">Semua Program <i
                        class="fas fa-arrow-right ml-2 text-[10px]"></i></a>
            </div>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="group reveal">
                    <div class="overflow-hidden rounded-3xl mb-8 shadow-xl"><img
                            src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600"
                            class="w-full h-72 object-cover transform group-hover:scale-110 transition duration-700"></div>
                    <h3 class="text-slate-900 text-xl font-bold group-hover:text-orange-500 transition">Tahfidz Quran</h3>
                    <p class="mt-4 text-sm text-slate-600">Metode menghafal intensif dengan target capaian yang terukur
                        setiap semester.</p>
                </div>
                <div class="group reveal">
                    <div class="overflow-hidden rounded-3xl mb-8 shadow-xl"><img
                            src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600"
                            class="w-full h-72 object-cover transform group-hover:scale-110 transition duration-700"></div>
                    <h3 class="text-slate-900 text-xl font-bold group-hover:text-orange-500 transition">Literasi Digital
                    </h3>
                    <p class="mt-4 text-sm text-slate-600">Penguasaan desain grafis, multimedia, dan dasar pemrograman
                        komputer.</p>
                </div>
                <div class="group reveal">
                    <div class="overflow-hidden rounded-3xl mb-8 shadow-xl"><img
                            src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=600"
                            class="w-full h-72 object-cover transform group-hover:scale-110 transition duration-700"></div>
                    <h3 class="text-slate-900 text-xl font-bold group-hover:text-orange-500 transition">Bahasa Global</h3>
                    <p class="mt-4 text-sm text-slate-600">Penerapan komunikasi aktif Bahasa Arab dan Inggris sebagai bekal
                        dakwah global.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-32 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="reveal">
                    <h2 class="text-slate-900 text-4xl font-black mb-6">Hubungi Layanan <br>Informasi</h2>
                    <p class="text-slate-600 mb-10">Admin kami siap melayani pertanyaan seputar prosedur seleksi santri
                        baru.</p>
                    <div class="space-y-8">
                        <div class="flex items-center gap-6">
                            <div
                                class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center text-orange-500 text-xl">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">WhatsApp</p>
                                <p class="text-lg font-bold text-slate-800">{{ $pengaturan->telepon ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            <div
                                class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center text-orange-500 text-xl">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Email Support</p>
                                <p class="text-lg font-bold text-slate-800">{{ $pengaturan->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-12 rounded-[3rem] shadow-2xl reveal border border-slate-100">
                    <form class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" placeholder="Nama"
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20">
                            <input type="email" placeholder="Email"
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20">
                        </div>
                        <textarea rows="4" placeholder="Pesan Anda..."
                            class="w-full px-6 py-4 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20"></textarea>
                        <button type="submit" class="w-full btn-brand py-4 justify-center text-lg">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-950 py-24 text-slate-400">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-3 gap-16 border-b border-white/5 pb-20">
                <div class="space-y-8">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <span
                            class="text-white font-black text-2xl tracking-tighter uppercase">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs">Mewujudkan seleksi santri yang transparan demi masa depan
                        generasi Qur'ani yang unggul.</p>
                </div>
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-widest mb-10">Tautan Cepat</h4>
                    <ul class="space-y-5 text-sm">
                        <li><a href="#beranda" class="hover:text-white transition">Halaman Utama</a></li>
                        <li><a href="#alur" class="hover:text-white transition">Alur Seleksi</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Portal Masuk</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-widest mb-10">Alamat</h4>
                    <p class="text-sm leading-loose">{{ $pengaturan->alamat ?? 'Cimahi, Jawa Barat' }}</p>
                </div>
            </div>
            <p class="mt-12 text-center text-[10px] font-bold uppercase tracking-[0.4em] text-slate-700">&copy;
                {{ date('Y') }} {{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}. All Rights Reserved.</p>
        </div>
    </footer>
@endsection
