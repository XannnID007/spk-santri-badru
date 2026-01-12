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
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        /* Body default: Latar putih & Teks Gelap agar terbaca di semua section */
        body {
            background-color: #ffffff;
            color: #1e293b;
            /* Slate 800 */
            overflow-x: hidden;
            margin: 0;
        }

        /* Style Animasi Reveal yang STABIL */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    </style>
    @yield('styles')
</head>

<body class="antialiased">
    @yield('content')

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // INTERSECTION OBSERVER: Metode paling handal untuk animasi scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.1
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".reveal").forEach(el => observer.observe(el));
        });

        @yield('scripts')
    </script>
</body>

</html>
