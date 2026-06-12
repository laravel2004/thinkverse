@extends('layouts.public')

@section('title', 'Daftar Course - ThinkVerse Premium')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 px-margin-mobile md:px-margin-desktop overflow-hidden">
        <div class="max-w-container-max mx-auto relative z-10 text-center md:text-left flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="md:w-3/5">
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-6">
                    Eksplorasi Kursus Kami
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-8">
                    Tingkatkan keahlian Anda dengan kurikulum yang dirancang secara profesional oleh instruktur terbaik di bidangnya. Dari desain hingga data, temukan jalur pembelajaran yang tepat untuk masa depan Anda.
                </p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <button class="px-8 py-4 rounded-full bg-primary-container text-white font-bold hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95">Mulai Belajar Sekarang</button>
                    <button class="px-8 py-4 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary/5 transition-all">Pelajari Roadmap</button>
                </div>
            </div>
            <div class="md:w-2/5 relative">
                <div class="w-full aspect-square rounded-[40px] overflow-hidden shadow-2xl relative border-8 border-white">
                    <img class="w-full h-full object-cover" alt="A diverse group of university students collaborating on a digital project" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQXBawLpTtmlAFvyP3DIS1Y5-usT467L7VuphQ8HIBGtk6B-wKfRKJFKRywDCCvyzVwhy8FKNyMacf7vROUod4Bm83sKgjGKItetg8TE0Vj6hTon7_f38E_uV2_SuUBUatJFd0x1gVRfa49yWxz5Y9gL4AglXM8WreoJe06rvwLqqoYx3CifsZ18emNr8Xw2Khx0J0hVNleEwiiw19PJFHf2UnlJC9HamIFanEkbViZbUJa4zBINxQhL3UlQypmx6FeCe2_98e8ul3">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/30 to-transparent"></div>
                </div>
                <!-- Decorative Element -->
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-secondary-fixed rounded-3xl -z-10 blur-xl opacity-60"></div>
                <div class="absolute -top-6 -right-6 w-48 h-48 bg-primary-fixed rounded-full -z-10 blur-2xl opacity-40"></div>
            </div>
        </div>
    </section>

    <!-- Search & Filter Chips -->
    <section class="pb-12 px-margin-mobile md:px-margin-desktop">
        <div class="max-w-container-max mx-auto">
            <div class="glass-card rounded-3xl p-6 md:p-8 mb-12 shadow-sm">
                <div class="flex flex-col gap-8">
                    <!-- Desktop Search -->
                    <div class="relative w-full max-w-2xl mx-auto">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary font-bold">search</span>
                        <input class="w-full pl-12 pr-6 py-4 rounded-2xl bg-white border-2 border-primary/10 focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all text-body-md outline-none" placeholder="Cari materi pembelajaran atau instruktur..." type="text">
                    </div>
                    <!-- Filter Chips -->
                    <div class="flex flex-wrap justify-center gap-3">
                        <button class="active-filter px-6 py-2.5 rounded-full font-label-md text-label-md transition-all border border-primary/20 hover:bg-primary/5 hover:text-primary">Semua</button>
                        <button class="px-6 py-2.5 rounded-full font-label-md text-label-md text-on-surface-variant border border-primary/10 bg-white hover:border-primary hover:text-primary transition-all">Matematika</button>
                        <button class="px-6 py-2.5 rounded-full font-label-md text-label-md text-on-surface-variant border border-primary/10 bg-white hover:border-primary hover:text-primary transition-all">IPA Terpadu</button>
                        <button class="px-6 py-2.5 rounded-full font-label-md text-label-md text-on-surface-variant border border-primary/10 bg-white hover:border-primary hover:text-primary transition-all">Bahasa Inggris</button>
                        <button class="px-6 py-2.5 rounded-full font-label-md text-label-md text-on-surface-variant border border-primary/10 bg-white hover:border-primary hover:text-primary transition-all">Coding</button>
                        <button class="px-6 py-2.5 rounded-full font-label-md text-label-md text-on-surface-variant border border-primary/10 bg-white hover:border-primary hover:text-primary transition-all">Desain Grafis</button>
                        <button class="px-6 py-2.5 rounded-full font-label-md text-label-md text-on-surface-variant border border-primary/10 bg-white hover:border-primary hover:text-primary transition-all">Bisnis Digital</button>
                    </div>
                </div>
            </div>

            <!-- Course Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($courses as $course)
                <article class="bg-white rounded-[24px] overflow-hidden border border-primary/5 soft-glow-shadow hover:shadow-xl transition-all duration-300 flex flex-col hover:-translate-y-1">
                    <div class="relative h-56 overflow-hidden bg-surface">
                        @if($course->thumbnail_path)
                            <img class="w-full h-full object-cover" alt="{{ $course->title }}" src="{{ Storage::url($course->thumbnail_path) }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-primary/30">
                                <span class="material-symbols-outlined text-6xl">school</span>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-primary/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ $course->level ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-1 mb-3 text-yellow-500 text-sm">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star_half</span>
                            <span class="text-on-surface-variant text-xs ml-1">(4.5)</span>
                        </div>
                        <h3 class="font-bold text-xl text-on-surface mb-3 leading-tight">{{ $course->title }}</h3>
                        <p class="text-sm text-on-surface-variant mb-6 line-clamp-2">
                            {{ $course->excerpt ?? Str::limit($course->description, 100) }}
                        </p>
                        <div class="mt-auto flex items-center border-t border-primary/5 pt-4 justify-between">
                            <span class="text-xs font-bold text-primary/60 uppercase tracking-wider">{{ $course->category ?? 'Umum' }}</span>
                            <a href="{{ route('courses.show', $course) }}" class="text-primary font-bold text-sm flex items-center group-hover:gap-2 transition-all">Detail <span class="material-symbols-outlined text-[18px] ml-1">arrow_forward</span></a>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 text-on-surface-variant">
                    <span class="material-symbols-outlined text-6xl mb-4 opacity-50">school</span>
                    <p class="font-bold text-xl">Belum ada kursus yang tersedia</p>
                </div>
                @endforelse
            </div>

            @if($courses->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $courses->links() }}
            </div>
            @endif

            <!-- Load More Button -->
            <div class="mt-16 text-center">
                <button class="px-10 py-4 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition-all duration-300 shadow-sm active:scale-95">
                    Lihat Lebih Banyak Kursus
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter / CTA -->
    <section class="py-section-gap px-margin-mobile md:px-margin-desktop">
        <div class="max-w-container-max mx-auto">
            <div class="gradient-primary rounded-[40px] p-8 md:p-16 text-white text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg mb-6">Mulai Perjalanan Belajar Anda</h2>
                    <p class="font-body-lg text-body-lg opacity-90 max-w-2xl mx-auto mb-10">
                        Dapatkan akses ke materi eksklusif dan komunitas belajar yang suportif. Daftar hari ini untuk mendapatkan rekomendasi kursus yang personal.
                    </p>
                    <div class="flex flex-col md:flex-row justify-center items-center gap-4 max-w-lg mx-auto">
                        <input class="w-full px-6 py-4 rounded-full text-on-surface bg-white border-none focus:ring-4 focus:ring-secondary/50" placeholder="Alamat email Anda" type="email">
                        <button class="w-full md:w-auto px-8 py-4 rounded-full bg-white text-primary font-bold whitespace-nowrap hover:bg-opacity-90 transition-all">Daftar Sekarang</button>
                    </div>
                </div>
                <!-- Decorative Circles -->
                <div class="absolute -top-12 -left-12 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </section>
@endsection
