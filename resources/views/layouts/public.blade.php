<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'ThinkVerse - Premium Learning Platform') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-[#faf8ff] font-body-md text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed">

<!-- Top Navigation Bar -->
<nav class="fixed top-0 left-0 right-0 z-50 backdrop-blur-xl bg-white/60 border-b border-primary/5">
    <div class="flex justify-between items-center h-24 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto w-full">
        <a class="font-display-lg text-[32px] font-extrabold text-primary tracking-tight hover:opacity-90 transition-opacity" href="{{ url('/') }}">
            ThinkVerse<span class="text-secondary">.</span>
        </a>
        <div class="hidden md:flex items-center gap-10">
            <a class="font-label-md text-label-md {{ request()->routeIs('home') ? 'text-primary font-bold relative after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-primary' : 'text-on-surface-variant font-medium hover:text-primary transition-colors' }}" href="{{ route('home') }}">Beranda</a>
            <a class="font-label-md text-label-md {{ request()->routeIs('courses') ? 'text-primary font-bold relative after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-primary' : 'text-on-surface-variant font-medium hover:text-primary transition-colors' }}" href="{{ route('courses') }}">Kursus</a>
            <a class="font-label-md text-label-md {{ request()->routeIs('about') ? 'text-primary font-bold relative after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-primary' : 'text-on-surface-variant font-medium hover:text-primary transition-colors' }}" href="{{ route('about') }}">Tentang Kami</a>
            <a class="font-label-md text-label-md {{ request()->routeIs('contact') ? 'text-primary font-bold relative after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-primary' : 'text-on-surface-variant font-medium hover:text-primary transition-colors' }}" href="{{ route('contact') }}">Kontak</a>
        </div>
        <div class="flex items-center gap-6">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hidden md:block font-label-md text-label-md text-primary font-bold px-6 py-2 rounded-full border border-primary/20 hover:bg-primary/5 transition-all">Admin Panel</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                    @csrf
                    <button type="submit" class="font-label-md text-label-md text-red-500 font-bold hover:text-red-700 transition-colors">Keluar</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white py-20 border-t border-primary/5">
<div class="grid grid-cols-1 md:grid-cols-12 gap-12 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="md:col-span-5 space-y-8" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<a class="font-display-lg text-[32px] font-extrabold text-primary tracking-tight" href="#">
                ThinkVerse<span class="text-secondary">.</span>
</a>
<p class="font-body-md text-on-surface-variant max-w-md leading-relaxed">
                Platform pembelajaran digital premium yang berfokus pada pengembangan keahlian teknologi dan kreatif yang paling relevan untuk masa depan.
            </p>
<div class="flex gap-6">
<a class="text-primary/60 hover:text-primary transition-colors" href="#">
<svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg>
</a>
<a class="text-primary/60 hover:text-primary transition-colors" href="#">
<svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
</a>
</div>
</div>
<div class="md:col-span-2 space-y-6" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<h4 class="font-title-lg text-on-background font-bold">Navigasi</h4>
<nav class="flex flex-col gap-4">
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Beranda</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Kursus</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Tentang Kami</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Kontak</a>
</nav>
</div>
<div class="md:col-span-2 space-y-6" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<h4 class="font-title-lg text-on-background font-bold">Bantuan</h4>
<nav class="flex flex-col gap-4">
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Pusat Bantuan</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="#">FAQ</a>
</nav>
</div>
<div class="md:col-span-3 space-y-6" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<h4 class="font-title-lg text-on-background font-bold">Kontak Kami</h4>
<div class="space-y-4">
<p class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-[20px]">location_on</span>
                    Jl. Pendidikan No. 123, Jakarta
                </p>
<p class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-[20px]">mail</span>
                    halo@muttylearning.com
                </p>
<p class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-[20px]">call</span>
                    +62 812-3456-7890
                </p>
</div>
</div>
</div>
<div class="mt-20 pt-10 border-t border-primary/5 text-center px-margin-mobile">
<p class="font-label-md text-on-surface-variant opacity-60">© {{ date('Y') }} ThinkVerse. Seluruh Hak Cipta Dilindungi.</p>
</div>
</footer>

<script>
    // Reveal animation
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        const animateElements = document.querySelectorAll('header > div, section > div, .grid > div');
        animateElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1)';
            observer.observe(el);
        });
    });
</script>
</body>
</html>
