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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #fafafa;
        }

        .sidebar {
            background: white;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
            border-right: 1px solid #f0f0f0;
        }

        .logo-img {
            width: 2.5rem;
            height: 2.5rem;
            object-fit: contain;
        }

        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background: #fff7ed;
            border-left-color: #f97316;
        }

        .sidebar-link.active {
            background: #fff7ed;
            border-left-color: #f97316;
            color: #f97316;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 1.25rem;
        }

        .topbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid #f0f0f0;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100vh;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        @yield('styles')
    </style>
</head>

<body>
    @php
        $pengaturan = \App\Models\Pengaturan::first();
    @endphp

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 fixed h-full overflow-y-auto">
            <div class="p-5">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    @if ($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="logo-img">
                    @else
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-mosque text-white"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-sm font-bold text-gray-800">{{ $pengaturan->nama_pesantren ?? 'Al-Badru' }}</h1>
                        <p class="text-xs text-gray-500">SPK Santri</p>
                    </div>
                </div>

                <!-- User Info -->
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-3 rounded-xl mb-6 border border-orange-200">
                    <div class="flex items-center space-x-3">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="font-semibold text-gray-800 truncate text-sm">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-orange-600 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">
                    @if (Auth::user()->role === 'pendaftar')
                        <a href="{{ route('pendaftar.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.dashboard') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('pendaftar.profil') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.profil') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('pendaftar.pendaftaran') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.pendaftaran') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-file-alt"></i>
                            <span>Pendaftaran</span>
                        </a>
                        <a href="{{ route('pendaftar.pengumuman') }}"
                            class="sidebar-link {{ request()->routeIs('pendaftar.pengumuman') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-bullhorn"></i>
                            <span>Pengumuman</span>
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.pendaftar') }}"
                            class="sidebar-link {{ request()->routeIs('admin.pendaftar*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-users"></i>
                            <span>Data Pendaftar</span>
                        </a>
                        <a href="{{ route('admin.perhitungan') }}"
                            class="sidebar-link {{ request()->routeIs('admin.perhitungan*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-calculator"></i>
                            <span>Perhitungan SMART</span>
                        </a>
                        <a href="{{ route('admin.kriteria.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.kriteria*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-sliders-h"></i>
                            <span>Kriteria</span>
                        </a>
                        <a href="{{ route('admin.periode.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.periode*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-calendar"></i>
                            <span>Periode</span>
                        </a>
                        <a href="{{ route('admin.pengaturan') }}"
                            class="sidebar-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                        <a href="{{ route('admin.laporan') }}"
                            class="sidebar-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-600 text-sm">
                            <i class="fas fa-file-pdf"></i>
                            <span>Laporan</span>
                        </a>
                    @endif
                </nav>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto main-content">
            <!-- Top Bar -->
            <header class="topbar sticky top-0 z-10">
                <div class="px-6 py-3.5 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-gray-800">@yield('title')</h2>
                        <p class="text-xs text-gray-500">{{ now()->format('l, d F Y') }}</p>
                    </div>
                    <a href="{{ route('landing') }}"
                        class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:shadow-lg transition text-sm font-medium">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
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
