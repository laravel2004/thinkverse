@extends('layouts.public')

@section('title', data_get($pageContent, 'hero.page_title'))

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 px-margin-mobile md:px-margin-desktop overflow-hidden">
        <div class="max-w-container-max mx-auto relative z-10 text-center flex flex-col items-center gap-6">
            <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface leading-tight">
                {{ data_get($pageContent, 'hero.title_before_highlight') }}<span class="text-gradient">{{ data_get($pageContent, 'hero.title_highlight') }}</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                {{ data_get($pageContent, 'hero.description') }}
            </p>
        </div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary-fixed/30 rounded-full blur-[100px] -z-10"></div>
    </section>

    <!-- Contact Form Section -->
    <section class="pb-24 px-margin-mobile md:px-margin-desktop">
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Contact Info -->
            <div class="lg:col-span-5 space-y-8">
                @foreach(data_get($pageContent, 'info.cards', []) as $card)
                <div class="glass-card rounded-3xl p-8 flex items-start gap-6 premium-shadow">
                    <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">{{ $card['icon'] }}</span>
                    </div>
                    <div>
                        <h3 class="font-title-lg text-title-lg text-on-background mb-2">{{ $card['title'] }}</h3>
                        <div class="text-on-surface-variant font-body-md text-body-md">
                            @foreach($card['lines'] ?? [] as $line)
                                {{ $line }}<br>
                            @endforeach
                            @if(!empty($card['link_label']))
                                @if($card['icon'] === 'call')
                                    <span class="text-primary font-bold mt-1 block">{{ $card['link_label'] }}</span>
                                @else
                                    <a href="{{ $card['link_url'] }}" class="text-primary font-bold hover:underline block">{{ $card['link_label'] }}</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-primary/5 premium-shadow">
                    <h2 class="font-headline-md text-headline-md text-primary mb-8">{{ data_get($pageContent, 'form.title') }}</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="font-label-md text-label-md text-on-surface-variant">Nama Lengkap</label>
                                <input type="text" class="w-full px-6 py-4 rounded-2xl bg-surface border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan nama Anda">
                            </div>
                            <div class="space-y-2">
                                <label class="font-label-md text-label-md text-on-surface-variant">Alamat Email</label>
                                <input type="email" class="w-full px-6 py-4 rounded-2xl bg-surface border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="email@contoh.com">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="font-label-md text-label-md text-on-surface-variant">Subjek</label>
                            <input type="text" class="w-full px-6 py-4 rounded-2xl bg-surface border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Topik pesan Anda">
                        </div>
                        <div class="space-y-2">
                            <label class="font-label-md text-label-md text-on-surface-variant">Pesan</label>
                            <textarea rows="5" class="w-full px-6 py-4 rounded-2xl bg-surface border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Tuliskan detail pertanyaan atau masukan Anda di sini..."></textarea>
                        </div>
                        <button type="button" class="w-full deep-purple-gradient text-on-primary py-4 rounded-2xl font-bold text-lg shadow-[0_15px_30px_rgba(99,14,212,0.2)] purple-glow-hover transition-all active:scale-95">
                            {{ data_get($pageContent, 'form.button_label') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
