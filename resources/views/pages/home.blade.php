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
                {{ data_get($pageContent, 'hero.badge') }}
            </div>
<h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-background leading-[1.1]">
                {{ data_get($pageContent, 'hero.title_before_highlight') }}<span class="text-gradient">{{ data_get($pageContent, 'hero.title_highlight') }}</span>{{ data_get($pageContent, 'hero.title_after_highlight') }}
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                {{ data_get($pageContent, 'hero.description') }}
            </p>
<div class="flex flex-col sm:flex-row gap-5 mt-4">
<a href="{{ data_get($pageContent, 'hero.primary_button_url') }}" class="deep-purple-gradient text-on-primary px-10 py-5 rounded-2xl font-bold text-lg shadow-[0_20px_40px_rgba(99,14,212,0.25)] purple-glow-hover transition-all flex items-center justify-center gap-3">
                    {{ data_get($pageContent, 'hero.primary_button_label') }}
                    <span class="material-symbols-outlined font-bold">arrow_forward</span>
</a>
<a href="{{ data_get($pageContent, 'hero.secondary_button_url') }}" class="bg-white text-primary border border-primary/10 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                    {{ data_get($pageContent, 'hero.secondary_button_label') }}
                </a>
</div>
</div>
<div class="lg:col-span-5 relative" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="relative z-10 aspect-square rounded-[2.5rem] overflow-hidden bg-white p-5 border border-white shadow-[0_40px_100px_rgba(124,58,237,0.15)] group">
@php
    $heroImg = data_get($pageContent, 'hero.image_url');
    $isHeroImgExternal = Str::startsWith($heroImg, ['http://', 'https://']);
    $resolvedHeroImg = $isHeroImgExternal ? $heroImg : Storage::url($heroImg);
@endphp
<img alt="{{ data_get($pageContent, 'hero.image_alt') }}" class="w-full h-full object-cover rounded-[1.8rem] transition-transform duration-700 group-hover:scale-105" src="{{ $resolvedHeroImg }}">
<!-- Floating Stats -->
<div class="absolute -bottom-8 -left-8 glass-card p-8 rounded-3xl premium-shadow border border-white/60 hidden md:block animate-bounce-slow">
<div class="flex items-center gap-5">
<div class="w-16 h-16 rounded-2xl deep-purple-gradient flex items-center justify-center text-white shadow-lg">
<span class="material-symbols-outlined text-3xl">groups</span>
</div>
<div>
<p class="text-3xl font-extrabold text-primary">{{ data_get($pageContent, 'hero.stat_number') }}</p>
<p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest opacity-70">{{ data_get($pageContent, 'hero.stat_label') }}</p>
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
@php
    $founderImg = data_get($pageContent, 'founder.photo_url');
    $isFounderImgExternal = Str::startsWith($founderImg, ['http://', 'https://']);
    $resolvedFounderImg = $isFounderImgExternal ? $founderImg : Storage::url($founderImg);
@endphp
<img alt="{{ data_get($pageContent, 'founder.photo_alt') }}" class="w-full h-full object-cover" src="{{ $resolvedFounderImg }}">
</div>
<div class="absolute -top-6 -right-6 w-32 h-32 bg-primary-container/20 rounded-full blur-3xl -z-10"></div>
</div>
<div class="flex-1 flex flex-col gap-8">
<div class="space-y-3">
<span class="text-secondary font-extrabold uppercase tracking-widest text-sm">{{ data_get($pageContent, 'founder.role') }}</span>
<h2 class="font-headline-md text-headline-md text-primary tracking-tight">{{ data_get($pageContent, 'founder.name') }}</h2>
<div class="h-1.5 w-24 bg-gradient-to-r from-primary to-secondary rounded-full"></div>
</div>
<p class="font-body-lg text-[22px] text-on-background italic leading-relaxed font-medium">
                {{ data_get($pageContent, 'founder.quote') }}
            </p>
<p class="font-body-md text-body-lg text-on-surface-variant">
                {{ data_get($pageContent, 'founder.bio') }}
            </p>
<div class="flex gap-4">
@foreach(data_get($pageContent, 'founder.social_links', []) as $slink)
<a class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all duration-300" href="{{ $slink['url'] }}" title="{{ $slink['label'] }}">
<span class="material-symbols-outlined">{{ $slink['icon'] }}</span>
</a>
@endforeach
</div>
</div>
</div>
</section>
<!-- Features Section -->
<section class="bg-surface-container-low/50 py-section-gap relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary/5 via-transparent to-transparent opacity-50" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);"></div>
<div class="relative z-10 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="text-center mb-20">
<h2 class="font-headline-md text-headline-md text-primary mb-6">{{ data_get($pageContent, 'features.title') }}</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl mx-auto opacity-80">
                {{ data_get($pageContent, 'features.description') }}
            </p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
@foreach(data_get($pageContent, 'features.items', []) as $item)
@php
    $colorVar = $item['color_variant'] ?? 'primary';
    $colorClasses = 'bg-primary/10 text-primary';
    if ($colorVar === 'secondary') {
        $colorClasses = 'bg-secondary/10 text-secondary';
    } elseif ($colorVar === 'tertiary') {
        $colorClasses = 'bg-tertiary/10 text-tertiary';
    } elseif ($colorVar === 'primary-fixed-dim') {
        $colorClasses = 'bg-primary-fixed-dim text-on-primary-fixed-variant';
    }
@endphp
<div class="glass-card-dark p-10 rounded-[2rem] hover:bg-white hover:shadow-2xl transition-all duration-500 group" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="w-16 h-16 rounded-2xl {{ $colorClasses }} flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl font-bold">{{ $item['icon'] }}</span>
</div>
<h3 class="font-title-lg text-title-lg text-primary mb-4">{{ $item['title'] }}</h3>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $item['description'] }}</p>
</div>
@endforeach
</div>
</div>
</section>
<!-- Course Preview Section -->
<section class="py-section-gap px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6" style="opacity: 1; transform: translateY(0px); transition: 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);">
<div class="space-y-4">
<h2 class="font-headline-md text-headline-md text-primary">{{ data_get($pageContent, 'course_preview.title') }}</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                {{ data_get($pageContent, 'course_preview.description') }}
            </p>
</div>
<a class="flex items-center gap-3 px-6 py-3 rounded-full bg-primary/5 text-primary font-bold group hover:bg-primary hover:text-white transition-all" href="{{ data_get($pageContent, 'course_preview.link_url') }}">
            {{ data_get($pageContent, 'course_preview.link_label') }}
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
            <p class="text-on-surface-variant font-medium text-lg">{{ data_get($pageContent, 'course_preview.empty_state_text') }}</p>
        </div>
    @endforelse
</div>
</section>
@endsection
