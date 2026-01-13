@extends('layouts.app')

@section('title', 'Login')

@section('styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #000;
        }

        .login-wrapper {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* Latar belakang dinamis */
        .background-image {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .background-image img,
        .background-image video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Overlay Gelap */
        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right,
                    rgba(0, 0, 0, 0.85) 0%,
                    rgba(0, 0, 0, 0.6) 50%,
                    rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        /* Form Card - Super Compact */
        .login-card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 320px;
            padding: 1.5rem;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            width: 3rem;
            height: 3rem;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .title-text {
            color: white;
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .subtitle-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 0.85rem;
        }

        .form-input {
            width: 100%;
            /* Padding kanan ditambah (2.5rem) agar teks tidak nabrak icon mata */
            padding: 0.6rem 2.5rem 0.6rem 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.6rem;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-input:focus {
            border-color: #f47200;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(244, 114, 0, 0.15);
        }

        /* Icon Kiri (Envelope/Lock) */
        .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            pointer-events: none;
            /* Agar klik tembus ke input */
        }

        /* Icon Kanan (Mata/Eye) */
        .toggle-password {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            cursor: pointer;
            transition: color 0.3s;
            z-index: 20;
        }

        .toggle-password:hover {
            color: white;
        }

        .checkbox-wrapper {
            margin-bottom: 1rem;
            font-size: 0.75rem;
        }

        .checkbox-wrapper label {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-primary {
            width: 100%;
            padding: 0.65rem;
            background: #f47200;
            color: white;
            border: none;
            border-radius: 0.6rem;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 12px -3px rgba(244, 114, 0, 0.3);
        }

        .btn-primary:hover {
            background: #ff8c00;
            transform: translateY(-2px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1rem 0;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.65rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 0.5rem;
        }

        .btn-secondary {
            width: 100%;
            padding: 0.6rem;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.6rem;
            font-weight: 600;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .back-link {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.7rem;
            transition: 0.3s;
            margin-top: 1rem;
            display: inline-block;
        }

        .back-link:hover {
            color: white;
        }

        .error-text {
            color: #f87171;
            font-size: 0.7rem;
            margin-top: 0.2rem;
        }
    </style>
@endsection

@section('content')
    <div class="login-wrapper">
        <div class="background-image">
            @php
                $banners = \App\Models\Banner::where('status_aktif', true)->orderBy('urutan')->get();
                $banner = $banners->first();
            @endphp
            @if ($banner)
                @if ($banner->tipe === 'video')
                    <video autoplay muted loop playsinline>
                        <source src="{{ asset('storage/' . $banner->file) }}" type="video/mp4">
                    </video>
                @else
                    <img src="{{ asset('storage/' . $banner->file) }}" alt="Background">
                @endif
            @else
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600" alt="Default Background">
            @endif
        </div>

        <div class="overlay"></div>

        <div class="login-card">
            <div class="logo-container">
                @php $pengaturan = \App\Models\Pengaturan::first(); @endphp
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo">
                @else
                    <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                @endif
            </div>

            <div class="text-center">
                <h2 class="title-text">Portal Masuk</h2>
                <p class="subtitle-text">Silakan masuk ke akun Anda</p>
            </div>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Email"
                        required autofocus>
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Password"
                        required>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>

                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-3 h-3 rounded bg-white/10 border-white/20">
                    <label for="remember" class="ml-2 cursor-pointer">Ingat saya</label>
                </div>

                <button type="submit" class="btn-primary">
                    MASUK
                </button>
            </form>

            <div class="divider"><span>ATAU</span></div>

            <a href="{{ route('register') }}" class="btn-secondary block text-center">
                Daftar Akun
            </a>

            <div class="text-center">
                <a href="{{ route('landing') }}" class="back-link inline-flex items-center gap-1">
                    <i class="fas fa-arrow-left text-[9px]"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function(e) {
                // Toggle tipe input antara password dan text
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle icon mata
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endsection
