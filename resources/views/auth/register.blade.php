@extends('layouts.app')

@section('title', 'Registrasi Akun Baru')

@section('styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #000;
        }

        .register-wrapper {
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

        /* Form Card - Widened (Dilebarkan) */
        .register-card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            /* REVISI: Dilebarkan dari 380px ke 450px */
            padding: 2rem;
            /* REVISI: Padding sedikit ditambah agar proporsional */
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
            width: 3.5rem;
            height: 3.5rem;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .title-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .subtitle-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            /* Gap diperjelas karena card lebih lebar */
        }

        .form-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.7rem 2.5rem 0.7rem 2.5rem;
            /* Padding disesuaikan */
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.7rem;
            font-size: 0.85rem;
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

        /* Icon Kiri */
        .input-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            pointer-events: none;
        }

        /* Icon Kanan (Mata) */
        .toggle-password {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            cursor: pointer;
            transition: color 0.3s;
            z-index: 20;
        }

        .toggle-password:hover {
            color: white;
        }

        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background: #f47200;
            color: white;
            border: none;
            border-radius: 0.7rem;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 12px -3px rgba(244, 114, 0, 0.3);
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            background: #ff8c00;
            transform: translateY(-2px);
        }

        .btn-secondary {
            width: 100%;
            padding: 0.7rem;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.7rem;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.25rem 0;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 0.75rem;
        }

        .back-link {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            transition: 0.3s;
            margin-top: 1rem;
            display: inline-block;
        }

        .back-link:hover {
            color: white;
        }

        .error-text {
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 500px) {
            .register-card {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                /* Stack di mobile */
                gap: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="register-wrapper">
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

        <div class="register-card">
            <div class="logo-container">
                @php $pengaturan = \App\Models\Pengaturan::first(); @endphp
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo">
                @else
                    <i class="fas fa-mosque text-orange-500 text-2xl"></i>
                @endif
            </div>

            <div class="text-center">
                <h2 class="title-text">Buat Akun</h2>
                <p class="subtitle-text">Lengkapi data untuk mendaftar</p>
            </div>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-input"
                            placeholder="Nama Lengkap" required>
                        @error('nama')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-input"
                            placeholder="No. HP" required>
                        @error('no_hp')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input"
                        placeholder="Alamat Email" required>
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-input" placeholder="Password"
                            required>
                        <i class="fas fa-eye toggle-password" data-target="password"></i>
                        @error('password')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <i class="fas fa-shield-alt input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input"
                            placeholder="Konfirmasi" required>
                        <i class="fas fa-eye toggle-password" data-target="password_confirmation"></i>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    DAFTAR
                </button>
            </form>

            <div class="divider"><span>ATAU</span></div>

            <a href="{{ route('login') }}" class="btn-secondary block text-center">
                Sudah Punya Akun? Login
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
            const togglePasswords = document.querySelectorAll('.toggle-password');

            togglePasswords.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);

                    if (input) {
                        const type = input.getAttribute('type') === 'password' ? 'text' :
                        'password';
                        input.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    }
                });
            });
        });
    </script>
@endsection
