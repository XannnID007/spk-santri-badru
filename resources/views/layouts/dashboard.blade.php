<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SPK Santri</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #f8fafc;
        }

        /* Sidebar Transition */
        .sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 17rem;
        }

        .sidebar.collapsed {
            width: 5rem;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .sidebar-group-title {
            opacity: 0;
            pointer-events: none;
            display: none;
        }

        /* Menu Link */
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.75rem;
            color: #64748b;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .menu-link:hover {
            background-color: #fff7ed;
            color: #ea580c;
        }

        .menu-link.active {
            background: linear-gradient(to right, #fff7ed, #fff);
            color: #ea580c;
            font-weight: 700;
            border-right: 3px solid #ea580c;
        }

        .menu-link i {
            font-size: 1.1rem;
            width: 1.5rem;
            text-align: center;
            flex-shrink: 0;
        }

        /* Main Content */
        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 17rem;
        }

        .main-content.collapsed {
            margin-left: 5rem;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
                width: 17rem !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .main-content.collapsed {
                margin-left: 0 !important;
            }

            .desktop-toggle {
                display: none !important;
            }

            .mobile-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(2px);
                z-index: 40;
                display: none;
            }

            .mobile-overlay.show {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>

<body x-data="{ sidebarOpen: true, mobileOpen: false }">
    @php $pengaturan = \App\Models\Pengaturan::first(); @endphp

    <div class="mobile-overlay" :class="{ 'show': mobileOpen }" @click="mobileOpen = false"></div>

    <div class="flex h-screen overflow-hidden">

        <aside class="sidebar fixed h-full bg-white border-r border-slate-200 z-40 flex flex-col shadow-sm"
            :class="{ 'collapsed': !sidebarOpen, 'mobile-open': mobileOpen }">

            <div class="h-20 flex items-center px-6 border-b border-slate-50 flex-shrink-0"
                :class="!sidebarOpen ? 'justify-center px-0' : 'justify-between'">
                <div class="flex items-center gap-3 overflow-hidden">
                    @if ($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo"
                            class="w-9 h-9 object-contain">
                    @else
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-mosque text-sm"></i>
                        </div>
                    @endif
                    <div class="logo-text transition-opacity duration-300">
                        <h1 class="text-sm font-extrabold text-slate-800">
                            {{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</h1>
                        <p class="text-[10px] text-slate-400 font-semibold uppercase">Portal Sistem</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scroll">
                @if (Auth::user()->role === 'pendaftar')
                    <a href="{{ route('pendaftar.dashboard') }}"
                        class="menu-link {{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i><span class="menu-text ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('pendaftar.profil') }}"
                        class="menu-link {{ request()->routeIs('pendaftar.profil') ? 'active' : '' }}">
                        <i class="far fa-user-circle"></i><span class="menu-text ml-3">Profil Saya</span>
                    </a>
                    <a href="{{ route('pendaftar.pendaftaran') }}"
                        class="menu-link {{ request()->routeIs('pendaftar.pendaftaran') ? 'active' : '' }}">
                        <i class="far fa-file-alt"></i><span class="menu-text ml-3">Pendaftaran</span>
                    </a>
                    <a href="{{ route('pendaftar.pengumuman') }}"
                        class="menu-link {{ request()->routeIs('pendaftar.pengumuman') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i><span class="menu-text ml-3">Pengumuman</span>
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}"
                        class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i><span class="menu-text ml-3">Dashboard</span>
                    </a>

                    <div
                        class="sidebar-group-title mt-6 mb-2 px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Master Data</div>
                    <a href="{{ route('admin.pendaftar') }}"
                        class="menu-link {{ request()->routeIs('admin.pendaftar*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i><span class="menu-text ml-3">Data Santri</span>
                    </a>
                    <a href="{{ route('admin.kriteria.index') }}"
                        class="menu-link {{ request()->routeIs('admin.kriteria*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i><span class="menu-text ml-3">Kriteria Seleksi</span>
                    </a>
                    <a href="{{ route('admin.periode.index') }}"
                        class="menu-link {{ request()->routeIs('admin.periode*') ? 'active' : '' }}">
                        <i class="far fa-calendar-alt"></i><span class="menu-text ml-3">Periode Daftar</span>
                    </a>

                    <div
                        class="sidebar-group-title mt-6 mb-2 px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Analisa</div>
                    <a href="{{ route('admin.perhitungan') }}"
                        class="menu-link {{ request()->routeIs('admin.perhitungan*') ? 'active' : '' }}">
                        <i class="fas fa-calculator"></i><span class="menu-text ml-3">Perhitungan</span>
                    </a>
                    <a href="{{ route('admin.laporan') }}"
                        class="menu-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                        <i class="far fa-file-pdf"></i><span class="menu-text ml-3">Laporan</span>
                    </a>

                    <div
                        class="sidebar-group-title mt-6 mb-2 px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Sistem</div>
                    <a href="{{ route('admin.pengaturan') }}"
                        class="menu-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i><span class="menu-text ml-3">Pengaturan</span>
                    </a>
                @endif
            </div>
        </aside>

        <div class="main-content flex-1 flex flex-col h-full min-h-screen relative"
            :class="{ 'collapsed': !sidebarOpen }">

            <header
                class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="mobileOpen = !mobileOpen"
                        class="lg:hidden text-slate-500 hover:text-orange-500 p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="desktop-toggle hidden lg:flex items-center justify-center w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 shadow-sm hover:text-orange-600 transition"
                        :class="!sidebarOpen ? 'rotate-180' : ''">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight">@yield('title')</h2>
                        <p class="text-xs text-slate-400 font-medium hidden sm:block">Sistem Pendukung Keputusan</p>
                    </div>
                </div>

                <div class="flex items-center gap-5">
                    <a href="{{ route('landing') }}"
                        class="group flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50 transition text-slate-500 hover:text-orange-600">
                        <div
                            class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-orange-100 transition">
                            <i class="fas fa-home text-xs"></i>
                        </div>
                        <span class="text-sm font-semibold hidden sm:inline">Beranda</span>
                    </a>

                    <div class="h-8 w-px bg-slate-100"></div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-slate-700 group-hover:text-orange-600 transition">
                                    {{ Auth::user()->nama }}</p>
                                <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">
                                    {{ Auth::user()->role }}</p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-400 to-red-500 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                            </div>
                            <i
                                class="fas fa-chevron-down text-[10px] text-slate-300 group-hover:text-orange-500 transition ml-1"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 origin-top-right"
                            style="display: none;">

                            <div class="px-5 py-3 border-b border-slate-50 md:hidden bg-slate-50/50">
                                <p class="text-sm font-bold text-slate-700">{{ Auth::user()->nama }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="p-1">
                                @if (Auth::user()->role === 'pendaftar')
                                    <a href="{{ route('pendaftar.profil') }}"
                                        class="flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-orange-50 hover:text-orange-600 rounded-xl transition">
                                        <i class="far fa-user mr-3 w-4 text-center"></i> Profil Saya
                                    </a>
                                @else
                                    <a href="{{ route('admin.pengaturan') }}"
                                        class="flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-orange-50 hover:text-orange-600 rounded-xl transition">
                                        <i class="fas fa-cog mr-3 w-4 text-center"></i> Pengaturan
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-slate-100 my-1"></div>

                            <div class="p-1">
                                <button type="button" onclick="confirmLogout()"
                                    class="w-full flex items-center px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 hover:text-red-600 rounded-xl transition">
                                    <i class="fas fa-power-off mr-3 w-4 text-center"></i> Keluar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8 custom-scroll relative z-0">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-slate-200 py-6 px-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 font-medium">
                    <p>&copy; {{ date('Y') }} <span
                            class="text-slate-700 font-bold">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</span>.
                        All rights reserved.</p>
                </div>
            </footer>

        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden" style="display: none;">
        @csrf
    </form>

    <script>
        // Global Script Setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast Notification Function
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#fff',
            color: '#334155',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Tampilkan Flash Message Laravel
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                iconColor: '#22c55e'
            });
        @endif
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                iconColor: '#ef4444'
            });
        @endif

        // --- FUNGSI LOGOUT GLOBAL ---
        window.confirmLogout = function() {
            // Debugging: Cek apakah fungsi terpanggil
            console.log('Tombol logout diklik');

            Swal.fire({
                title: 'Keluar dari Sesi?',
                text: "Anda harus login kembali untuk mengakses halaman ini.",
                icon: 'question',
                iconColor: '#f97316', // Orange
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-2xl font-sans',
                    confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-200',
                    cancelButton: 'px-6 py-2.5 rounded-xl font-bold text-slate-600'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cari form dan submit
                    const form = document.getElementById('logout-form');
                    if (form) {
                        form.submit();
                    } else {
                        console.error('Form logout tidak ditemukan!');
                        Swal.fire('Error', 'Form logout missing', 'error');
                    }
                }
            });
        }
    </script>

    @yield('scripts')
</body>

</html>
