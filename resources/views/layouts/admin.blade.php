<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'ThinkVerse') }}</title>
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

<body class="bg-[#faf8ff] font-body-md text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed antialiased overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen w-full">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-primary/5 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static flex flex-col flex-shrink-0 h-screen">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-20 px-8 border-b border-primary/5 flex-shrink-0">
                <a class="font-display-lg text-[24px] font-extrabold text-primary tracking-tight" href="{{ route('admin.dashboard') }}">
                    ThinkVerse<span class="text-secondary">.</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface hover:text-primary transition-colors font-medium' }}">
                    <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.dashboard') ? 'font-variation-settings:\'FILL\'_1' : '' }}">space_dashboard</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.courses.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface hover:text-primary transition-colors font-medium' }}">
                    <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.courses.*') ? 'font-variation-settings:\'FILL\'_1' : '' }}">school</span>
                    Kursus
                </a>
                <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.pages.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface hover:text-primary transition-colors font-medium' }}">
                    <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.pages.*') ? 'font-variation-settings:\'FILL\'_1' : '' }}">description</span>
                    Konten Halaman
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.users.*') ? 'bg-primary/10 text-primary font-bold' : 'text-on-surface-variant hover:bg-surface hover:text-primary transition-colors font-medium' }}">
                    <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.users.*') ? 'font-variation-settings:\'FILL\'_1' : '' }}">group</span>
                    Pengguna
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-on-surface-variant hover:bg-surface hover:text-primary transition-colors font-medium">
                    <span class="material-symbols-outlined text-[22px]">settings</span>
                    Pengaturan
                </a>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-6 border-t border-primary/5 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-on-surface-variant hover:bg-surface hover:text-primary transition-colors font-medium mb-2">
                    <span class="material-symbols-outlined text-[22px]">public</span>
                    Kembali ke Web
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl text-red-500 hover:bg-red-50 transition-colors font-bold">
                        <span class="material-symbols-outlined text-[22px]">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden relative">

            <!-- Top Navbar -->
            <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-primary/5 flex items-center justify-between px-4 lg:px-8 z-30 sticky top-0 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-on-surface-variant hover:text-primary focus:outline-none p-2 rounded-xl hover:bg-surface transition-colors">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="font-headline-md text-xl font-bold text-on-background">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 rounded-full bg-surface flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors relative">
                        <span class="material-symbols-outlined text-[20px]">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500"></span>
                    </button>
                    <div class="h-10 border-l border-primary/10 mx-2"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="hidden md:block">
                            <p class="font-label-md font-bold text-on-surface">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-on-surface-variant">Administrator</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>