@extends('layouts.public')

@section('title', data_get($pageContent, 'hero.page_title'))

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 px-margin-mobile md:px-margin-desktop overflow-hidden">
        <div class="max-w-container-max mx-auto relative z-10 text-center flex flex-col items-center gap-8">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/50 border border-primary/10 text-primary text-label-md font-bold backdrop-blur-sm">
                {{ data_get($pageContent, 'hero.badge') }}
            </div>
            <h1 class="font-display-lg text-display-lg-mobile md:text-[56px] text-on-surface leading-tight max-w-4xl">
                {{ data_get($pageContent, 'hero.title_before_highlight') }}<span class="text-gradient">{{ data_get($pageContent, 'hero.title_highlight') }}</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                {{ data_get($pageContent, 'hero.description') }}
            </p>
        </div>
        <!-- Decorative Element -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-fixed-dim/20 rounded-full blur-[100px] -z-10 animate-pulse"></div>
    </section>

    <!-- Content Section -->
    <section class="pb-24 px-margin-mobile md:px-margin-desktop">
        <div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="glass-card rounded-[3rem] p-10 md:p-16 premium-shadow">
                <h2 class="font-headline-md text-headline-md text-primary mb-6">{{ data_get($pageContent, 'vision.title') }}</h2>
                <div class="space-y-6 text-on-surface-variant font-body-md text-body-md leading-relaxed">
                    @foreach(data_get($pageContent, 'vision.paragraphs', []) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <div class="aspect-square rounded-[3rem] overflow-hidden shadow-2xl relative border-8 border-white">
                    @php
                        $visionImg = data_get($pageContent, 'vision.image_url');
                        $isVisionImgExternal = Str::startsWith($visionImg, ['http://', 'https://']);
                        $resolvedVisionImg = $isVisionImgExternal ? $visionImg : Storage::url($visionImg);
                    @endphp
                    <img class="w-full h-full object-cover" alt="{{ data_get($pageContent, 'vision.image_alt') }}" src="{{ $resolvedVisionImg }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
