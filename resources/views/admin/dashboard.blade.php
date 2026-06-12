@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard')

@section('content')
    <!-- Greeting -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-on-surface mb-2">Selamat Datang, <span class="text-gradient">{{ auth()->user()->name ?? 'Admin' }}</span>!</h1>
        <p class="text-on-surface-variant font-body-md">Berikut adalah ringkasan aktivitas platform ThinkVerse hari ini.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-6 border border-transparent shadow-sm hover:-translate-y-1 hover:border-primary/20 hover:shadow-[0_15px_30px_rgba(99,14,212,0.1)] relative overflow-hidden group transition-all duration-300">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-bl from-primary/10 to-transparent rounded-full group-hover:scale-[1.5] group-hover:from-primary/20 transition-all duration-500 ease-out z-0"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white group-hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-on-surface-variant font-medium text-sm mb-1">Total Siswa</p>
                <h3 class="font-title-lg text-3xl font-extrabold text-on-surface group-hover:text-primary transition-colors duration-300">{{ number_format($stats['students']) }}</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-6 border border-transparent shadow-sm hover:-translate-y-1 hover:border-secondary/20 hover:shadow-[0_15px_30px_rgba(236,72,153,0.1)] relative overflow-hidden group transition-all duration-300">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-bl from-secondary/10 to-transparent rounded-full group-hover:scale-[1.5] group-hover:from-secondary/20 transition-all duration-500 ease-out z-0"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-secondary/10 text-secondary group-hover:bg-secondary group-hover:text-white group-hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                    <span class="material-symbols-outlined">school</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-on-surface-variant font-medium text-sm mb-1">Total Kursus</p>
                <h3 class="font-title-lg text-3xl font-extrabold text-on-surface group-hover:text-secondary transition-colors duration-300">{{ number_format($stats['courses']) }}</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-6 border border-transparent shadow-sm hover:-translate-y-1 hover:border-blue-500/20 hover:shadow-[0_15px_30px_rgba(59,130,246,0.1)] relative overflow-hidden group transition-all duration-300">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-bl from-blue-500/10 to-transparent rounded-full group-hover:scale-[1.5] group-hover:from-blue-500/20 transition-all duration-500 ease-out z-0"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                    <span class="material-symbols-outlined">task</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-on-surface-variant font-medium text-sm mb-1">Pengumpulan Tugas</p>
                <h3 class="font-title-lg text-3xl font-extrabold text-on-surface group-hover:text-blue-600 transition-colors duration-300">{{ number_format($stats['submissions']) }}</h3>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-6 border border-transparent shadow-sm hover:-translate-y-1 hover:border-emerald-500/20 hover:shadow-[0_15px_30px_rgba(16,185,129,0.1)] relative overflow-hidden group transition-all duration-300">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-gradient-to-bl from-emerald-500/10 to-transparent rounded-full group-hover:scale-[1.5] group-hover:from-emerald-500/20 transition-all duration-500 ease-out z-0"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white group-hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-on-surface-variant font-medium text-sm mb-1">Total Materi</p>
                <h3 class="font-title-lg text-3xl font-extrabold text-on-surface group-hover:text-emerald-600 transition-colors duration-300">{{ number_format($stats['lessons']) }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] p-8 border border-primary/5 premium-shadow">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-headline-md text-xl font-bold text-on-surface">Aktivitas Terbaru</h2>
            <button class="text-primary font-bold text-sm hover:underline" disabled>Lihat Semua</button>
        </div>
        
        @if($activities->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center text-on-surface-variant/50 mb-4">
                    <span class="material-symbols-outlined text-4xl">history</span>
                </div>
                <h3 class="font-title-lg text-on-surface mb-2">Belum ada aktivitas</h3>
                <p class="text-on-surface-variant font-body-md max-w-md">Data aktivitas pengguna dan pendaftaran kursus akan muncul di sini.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($activities as $activity)
                    @if($activity['url'])
                        <a href="{{ $activity['url'] }}" class="flex items-start gap-4 p-4 rounded-2xl hover:bg-surface/50 transition-colors group">
                    @else
                        <div class="flex items-start gap-4 p-4 rounded-2xl">
                    @endif
                        <div class="w-12 h-12 rounded-full {{ $activity['badge_color'] }} flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined">{{ $activity['icon'] }}</span>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-on-surface {{ $activity['url'] ? 'group-hover:text-primary transition-colors' : '' }}">{{ $activity['title'] }}</h3>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $activity['badge_color'] }}">{{ $activity['label'] }}</span>
                                </div>
                                <span class="text-xs font-medium text-on-surface-variant" title="{{ $activity['time']->format('d M Y, H:i') }}">{{ $activity['time']->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-on-surface-variant">{{ $activity['description'] }}</p>
                        </div>
                    @if($activity['url'])
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
