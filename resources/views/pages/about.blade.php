@extends('layouts.public')

@section('title', 'Tentang Kami - ThinkVerse Premium')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 px-margin-mobile md:px-margin-desktop overflow-hidden">
        <div class="max-w-container-max mx-auto relative z-10 text-center flex flex-col items-center gap-8">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/50 border border-primary/10 text-primary text-label-md font-bold backdrop-blur-sm">
                Misi Kami
            </div>
            <h1 class="font-display-lg text-display-lg-mobile md:text-[56px] text-on-surface leading-tight max-w-4xl">
                Membangun Ekosistem Pendidikan yang <span class="text-gradient">Inklusif & Modern</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                ThinkVerse didirikan dengan satu tujuan: menjadikan pendidikan berkualitas tinggi dapat diakses oleh siapa saja, di mana saja, dengan teknologi pembelajaran terkini.
            </p>
        </div>
        <!-- Decorative Element -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-fixed-dim/20 rounded-full blur-[100px] -z-10 animate-pulse"></div>
    </section>

    <!-- Content Section -->
    <section class="pb-24 px-margin-mobile md:px-margin-desktop">
        <div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="glass-card rounded-[3rem] p-10 md:p-16 premium-shadow">
                <h2 class="font-headline-md text-headline-md text-primary mb-6">Visi & Nilai Inti</h2>
                <div class="space-y-6 text-on-surface-variant font-body-md text-body-md leading-relaxed">
                    <p>
                        Kami percaya bahwa belajar tidak boleh berhenti di ruang kelas. Melalui ThinkVerse, kami membawa ruang kelas tersebut ke dalam genggaman Anda dengan materi interaktif yang dirancang khusus oleh para pakar di industri.
                    </p>
                    <p>
                        Setiap kurikulum kami dikembangkan dengan pendekatan yang menitikberatkan pada pemahaman mendalam, bukan sekadar hafalan. Kami mengutamakan kualitas visual, kemudahan akses, dan komunitas pendukung yang aktif.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square rounded-[3rem] overflow-hidden shadow-2xl relative border-8 border-white">
                    <img class="w-full h-full object-cover" alt="Tim ThinkVerse" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQXBawLpTtmlAFvyP3DIS1Y5-usT467L7VuphQ8HIBGtk6B-wKfRKJFKRywDCCvyzVwhy8FKNyMacf7vROUod4Bm83sKgjGKItetg8TE0Vj6hTon7_f38E_uV2_SuUBUatJFd0x1gVRfa49yWxz5Y9gL4AglXM8WreoJe06rvwLqqoYx3CifsZ18emNr8Xw2Khx0J0hVNleEwiiw19PJFHf2UnlJC9HamIFanEkbViZbUJa4zBINxQhL3UlQypmx6FeCe2_98e8ul3">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
