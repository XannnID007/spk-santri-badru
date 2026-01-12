<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SPK Santri Al-Badru</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-orange {
            background: rgba(234, 88, 12, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(234, 88, 12, 0.3);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
        }

        .sidebar-link {
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(234, 88, 12, 0.2);
            border-left: 4px solid #ea580c;
        }

        .sidebar-link.active {
            background: rgba(234, 88, 12, 0.3);
            border-left: 4px solid #ea580c;
        }

        @yield('styles')
    </style>
</head>

<body class="bg-gray-900 text-white">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 glass-dark fixed h-full overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 gradient-orange rounded-full flex items-center justify-center">
                        <i class="fas fa-mosque text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">PP Al-Badru</h1>
                        <p class="text-xs text-gray-400">SPK Santri</p>
                    </div>
                </div>

                <!-- User Info -->
                <div class="glass-orange p-4 rounded-xl mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-2xl text-gray-300"></i>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="font-semibold text-white truncate">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    @if (Auth::user()->role === 'pendaftar')
                        <a href="{{ route('pendaftar.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('pendaftar.profil') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.profil') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-user-circle w-5"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('pendaftar.pendaftaran') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.pendaftaran') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-file-alt w-5"></i>
                            <span>Pendaftaran</span>
                        </a>
                        <a href="{{ route('pendaftar.pengumuman') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.pengumuman') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-bullhorn w-5"></i>
                            <span>Pengumuman</span>
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.pendaftar') }}"
                            class="sidebar-link {{ request()->routeIs('admin.pendaftar*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-users w-5"></i>
                            <span>Data Pendaftar</span>
                        </a>
                        <a href="{{ route('admin.perhitungan') }}"
                            class="sidebar-link {{ request()->routeIs('admin.perhitungan*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-calculator w-5"></i>
                            <span>Perhitungan SMART</span>
                        </a>
                        <a href="{{ route('admin.kriteria.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.kriteria*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-sliders-h w-5"></i>
                            <span>Kriteria & Bobot</span>
                        </a>
                        <a href="{{ route('admin.periode.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.periode*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-calendar-alt w-5"></i>
                            <span>Periode Pendaftaran</span>
                        </a>
                        <a href="{{ route('admin.pengaturan') }}"
                            class="sidebar-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-cog w-5"></i>
                            <span>Pengaturan</span>
                        </a>
                        <a href="{{ route('admin.laporan') }}"
                            class="sidebar-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                            <i class="fas fa-file-pdf w-5"></i>
                            <span>Laporan</span>
                        </a>
                    @endif
                </nav>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto">
            <!-- Top Bar -->
            <header class="glass-dark sticky top-0 z-10">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-white">@yield('title')</h2>
                        <p class="text-sm text-gray-400">{{ now()->format('l, d F Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('landing') }}"
                            class="glass-orange px-4 py-2 rounded-lg hover:bg-orange-500/20 transition">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="min-h-screen">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @yield('scripts')
    </script>
</body>

</html>
