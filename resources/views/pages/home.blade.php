@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<header class="relative overflow-hidden pt-40 pb-32 md:pt-56 md:pb-48 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<!-- Background decorative elements -->
<div class="absolute -top-48 -right-48 w-[600px] h-[600px] bg-primary-fixed-dim/20 rounded-full blur-[120px] -z-10 animate-pulse" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);"></div>
<div class="absolute top-1/2 -left-48 w-[500px] h-[500px] bg-secondary-fixed/30 rounded-full blur-[100px] -z-10" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);"></div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="lg:col-span-7 flex flex-col gap-8" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/50 border border-primary/10 text-primary text-label-md font-bold self-start backdrop-blur-sm">
<span class="flex h-2 w-2 rounded-full bg-primary animate-ping"></span>
                Platform Pembelajaran Terstruktur
            </div>
<h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-background leading-[1.1]">
                Belajar lebih mudah dengan <span class="text-gradient">ThinkVerse</span>
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                Akses materi terstruktur, video pembelajaran berkualitas HD, dan buku digital eksklusif yang dirancang oleh pakar industri untuk membantu Anda menguasai keahlian baru secara efektif.
            </p>
<div class="flex flex-col sm:flex-row gap-5 mt-4">
<button class="deep-purple-gradient text-on-primary px-10 py-5 rounded-2xl font-bold text-lg shadow-[0_20px_40px_rgba(99,14,212,0.25)] purple-glow-hover transition-all flex items-center justify-center gap-3">
                    Mulai Belajar Sekarang
                    <span class="material-symbols-outlined font-bold">arrow_forward</span>
</button>
<a href="{{ route('courses') }}" class="bg-white text-primary border border-primary/10 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                    Lihat Katalog Course
                </a>
</div>
</div>
<div class="lg:col-span-5 relative" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="relative z-10 aspect-square rounded-[2.5rem] overflow-hidden bg-white p-5 border border-white shadow-[0_40px_100px_rgba(124,58,237,0.15)] group">
<img alt="Dashboard Pembelajaran ThinkVerse" class="w-full h-full object-cover rounded-[1.8rem] transition-transform duration-700 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKVH2gaf5t7dV9-fR-4nfTgZ1QxCFEmlWvK4MxT1wi4xHTEPKvz561x8gB9wJafU9iuMTHtHTpkR3U3KvmPp1dZthpf4wxrjv0Vw4EXrMziJvTdABnLs7dSN4q7TqUQWQYK3TTu61VaeT129q7Q5Xq72u_5FU9C38YYEsQUH3oCY-3PqpWFEpxwQbrGClhx9ASXw7JnoWCdFi_WDMsoSk0_Egx5HZRlPG2CillXo5pvHYcGegvS4SuG-A6Q6pXxSgEVzbpRqxOJ6R7">
<!-- Floating Stats -->
<div class="absolute -bottom-8 -left-8 glass-card p-8 rounded-3xl premium-shadow border border-white/60 hidden md:block animate-bounce-slow">
<div class="flex items-center gap-5">
<div class="w-16 h-16 rounded-2xl deep-purple-gradient flex items-center justify-center text-white shadow-lg">
<span class="material-symbols-outlined text-3xl">groups</span>
</div>
<div>
<p class="text-3xl font-extrabold text-primary">10,000+</p>
<p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest opacity-70">Siswa Terdaftar</p>
</div>
</div>
</div>
</div>
<!-- Decorative circle -->
<div class="absolute -z-10 -bottom-10 -right-10 w-48 h-48 border-4 border-dashed border-primary/20 rounded-full"></div>
</div>
</div>
</header>
<!-- Profile Section -->
<section class="py-section-gap px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="glass-card rounded-[3rem] p-10 md:p-16 flex flex-col md:flex-row gap-16 items-center bg-white/60" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="w-full md:w-[400px] flex-shrink-0 relative">
<div class="aspect-[4/5] rounded-[2rem] overflow-hidden premium-shadow border-[8px] border-white relative z-10">
<img alt="Mutty Hariyati" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKI49zXO1QZJGBGkc2qOneZQgBcHJdw1nrRWmW8iOpZKGBlqg8ZT71wVyw_5UooHk58gsAfPKXud02xqaeI3wjDKhpBt43YZgCPZfI-aCIGFkGVfHWc3Tf1nG5CC4o1vwh-aodH-10btJBi7MrdBYzc6vXZwdyQwkIhItv6Kmd41IDIyH_BxmMVp3ZDQTBbu_zZgxaSFRBIRcrZ-sdwz0Ze1PkmpDMdYlL9NK-MvX4fJrE2KooqKVb9fZ1kCvrs5_Cxmh43NnvCDTR">
</div>
<div class="absolute -top-6 -right-6 w-32 h-32 bg-primary-container/20 rounded-full blur-3xl -z-10"></div>
</div>
<div class="flex-1 flex flex-col gap-8">
<div class="space-y-3">
<span class="text-secondary font-extrabold uppercase tracking-widest text-sm">Founder &amp; Lead Mentor</span>
<h2 class="font-headline-md text-headline-md text-primary tracking-tight">Mutty Hariyati</h2>
<div class="h-1.5 w-24 bg-gradient-to-r from-primary to-secondary rounded-full"></div>
</div>
<p class="font-body-lg text-[22px] text-on-background italic leading-relaxed font-medium">
                "Saya percaya bahwa pendidikan berkualitas tidak harus membosankan. Melalui ThinkVerse, saya berkomitmen untuk menyederhanakan materi kompleks agar mudah dikuasai oleh siapa saja."
            </p>
<p class="font-body-md text-body-lg text-on-surface-variant">
                Dengan pengalaman lebih dari 8 tahun di dunia pendidikan digital, Mutty telah membantu ribuan siswa mencapai potensi maksimal mereka melalui kurikulum yang adaptif dan metode pengajaran yang sangat interaktif.
            </p>
<div class="flex gap-4">
<a class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all duration-300" href="#">
<span class="material-symbols-outlined">public</span>
</a>
<a class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all duration-300" href="#">
<span class="material-symbols-outlined">alternate_email</span>
</a>
</div>
</div>
</div>
</section>
<!-- Features Section -->
<section class="bg-surface-container-low/50 py-section-gap relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary/5 via-transparent to-transparent opacity-50" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);"></div>
<div class="relative z-10 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="text-center mb-20">
<h2 class="font-headline-md text-headline-md text-primary mb-6">Kenapa Belajar di ThinkVerse?</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl mx-auto opacity-80">
                Kami menghadirkan ekosistem pembelajaran digital terlengkap untuk memastikan Anda mendapatkan hasil yang terukur dan aplikatif.
            </p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
<!-- Feature 1 -->
<div class="glass-card-dark p-10 rounded-[2rem] hover:bg-white hover:shadow-2xl transition-all duration-500 group" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-8 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl font-bold">menu_book</span>
</div>
<h3 class="font-title-lg text-title-lg text-primary mb-4">Kurikulum Terstruktur</h3>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Materi yang disusun secara sistematis per bab untuk memudahkan pemahaman dari level dasar hingga ahli.</p>
</div>
<!-- Feature 2 -->
<div class="glass-card-dark p-10 rounded-[2rem] hover:bg-white hover:shadow-2xl transition-all duration-500 group" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="w-16 h-16 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary mb-8 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl font-bold">play_circle</span>
</div>
<h3 class="font-title-lg text-title-lg text-primary mb-4">Video Pembelajaran HD</h3>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Nikmati pengalaman belajar visual dengan kualitas sinematik yang jernih dan penjelasan yang mendalam.</p>
</div>
<!-- Feature 3 -->
<div class="glass-card-dark p-10 rounded-[2rem] hover:bg-white hover:shadow-2xl transition-all duration-500 group" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="w-16 h-16 rounded-2xl bg-tertiary/10 flex items-center justify-center text-tertiary mb-8 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl font-bold">auto_stories</span>
</div>
<h3 class="font-title-lg text-title-lg text-primary mb-4">E-Book Eksklusif</h3>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Setiap kursus dilengkapi dengan buku panduan digital sebagai referensi cepat dan materi pengayaan.</p>
</div>
<!-- Feature 4 -->
<div class="glass-card-dark p-10 rounded-[2rem] hover:bg-white hover:shadow-2xl transition-all duration-500 group" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="w-16 h-16 rounded-2xl bg-primary-fixed-dim flex items-center justify-center text-on-primary-fixed-variant mb-8 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl font-bold">forum</span>
</div>
<h3 class="font-title-lg text-title-lg text-primary mb-4">Komunitas &amp; Diskusi</h3>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">Bergabung dengan ribuan pelajar lainnya untuk berkolaborasi, bertanya, dan tumbuh bersama mentor.</p>
</div>
</div>
</div>
</section>
<!-- Course Preview Section -->
<section class="py-section-gap px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="space-y-4">
<h2 class="font-headline-md text-headline-md text-primary">Katalog Kursus Unggulan</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                Temukan jalur belajar yang tepat untuk meningkatkan karier dan keahlian Anda di dunia digital.
            </p>
</div>
<a class="flex items-center gap-3 px-6 py-3 rounded-full bg-primary/5 text-primary font-bold group hover:bg-primary hover:text-white transition-all" href="{{ route('courses') }}">
            Lihat Semua Kursus
            <span class="material-symbols-outlined group-hover:translate-x-2 transition-transform">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
    @forelse($latestCourses as $course)
        <a href="{{ route('courses.show', $course) }}" class="bg-white rounded-[2rem] overflow-hidden premium-shadow border border-primary/5 group block" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
            <div class="h-60 overflow-hidden relative">
                @if($course->thumbnail_path)
                    <img alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ Storage::url($course->thumbnail_path) }}">
                @else
                    <div class="w-full h-full bg-surface flex items-center justify-center text-primary/30 group-hover:scale-110 transition-transform duration-700">
                        <span class="material-symbols-outlined text-6xl">school</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                    <span class="text-white font-bold text-sm">Klik untuk detail</span>
                </div>
                <span class="absolute top-6 left-6 px-4 py-1.5 bg-white/90 backdrop-blur-md text-primary text-xs font-extrabold rounded-full shadow-sm">{{ strtoupper($course->category ?? 'UMUM') }}</span>
            </div>
            <div class="p-8 flex flex-col justify-between h-[280px]">
                <div>
                    <h3 class="font-title-lg text-[24px] text-on-background mb-4 leading-tight group-hover:text-primary transition-colors line-clamp-2">{{ $course->title }}</h3>
                    <p class="font-body-md text-on-surface-variant mb-8 line-clamp-2">{{ $course->excerpt ?? Str::limit($course->description, 100) }}</p>
                </div>
                
                <button class="w-full py-4 rounded-2xl border-2 border-primary/10 text-primary font-bold group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all pointer-events-none mt-auto">
                    Lihat Kurikulum
                </button>
            </div>
        </a>
    @empty
        <div class="col-span-1 lg:col-span-3 text-center py-16 bg-surface rounded-[2rem] border border-primary/5">
            <span class="material-symbols-outlined text-6xl text-primary/30 mb-4">auto_stories</span>
            <p class="text-on-surface-variant font-medium text-lg">Belum ada kursus yang diterbitkan.</p>
        </div>
    @endforelse
</div>
</section>
@endsection
