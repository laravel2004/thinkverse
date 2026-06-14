@extends('layouts.public')

@section('title', data_get($pageContent, 'hero.page_title'))

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 px-margin-mobile md:px-margin-desktop overflow-hidden">
        <div class="max-w-container-max mx-auto relative z-10 text-center md:text-left flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="md:w-3/5">
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-6">
                    {{ data_get($pageContent, 'hero.title') }}
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-8">
                    {{ data_get($pageContent, 'hero.description') }}
                </p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <a href="{{ url('/courses#list-kursus') }}" class="px-8 py-4 rounded-full bg-primary-container text-white font-bold hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95 flex items-center justify-center">{{ data_get($pageContent, 'hero.primary_button_label') }}</a>
                    <a href="{{ url('/about') }}" class="px-8 py-4 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary/5 transition-all flex items-center justify-center">{{ data_get($pageContent, 'hero.secondary_button_label') }}</a>
                </div>
            </div>
            <div class="md:w-2/5 relative">
                <div class="w-full aspect-square rounded-[40px] overflow-hidden shadow-2xl relative border-8 border-white">
                    @php
                        $coursesHeroImg = data_get($pageContent, 'hero.image_url');
                        $isCoursesHeroImgExternal = Str::startsWith($coursesHeroImg, ['http://', 'https://']);
                        $resolvedCoursesHeroImg = $isCoursesHeroImgExternal ? $coursesHeroImg : Storage::url($coursesHeroImg);
                    @endphp
                    <img class="w-full h-full object-cover" alt="{{ data_get($pageContent, 'hero.image_alt') }}" src="{{ $resolvedCoursesHeroImg }}">
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
                    <form method="GET" action="{{ route('courses') }}" class="w-full max-w-2xl mx-auto">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary font-bold">search</span>
                                <input
                                    class="w-full pl-12 pr-6 py-4 rounded-2xl bg-white border-2 border-primary/10 focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all text-body-md outline-none"
                                    placeholder="{{ data_get($pageContent, 'filters.search_placeholder') }}"
                                    type="search"
                                    name="q"
                                    value="{{ $searchQuery ?? '' }}"
                                >
                            </div>
                            @if(($selectedCategory ?? '') !== '')
                                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                            @endif
                            <button type="submit" class="px-8 py-4 rounded-2xl bg-primary text-white font-bold hover:bg-primary/90 transition-all active:scale-95 whitespace-nowrap">
                                Cari
                            </button>
                        </div>
                    </form>
                    @if(($searchQuery ?? '') !== '')
                        <div class="flex justify-center">
                            <a href="{{ route('courses', request()->filled('category') ? ['category' => $selectedCategory] : []) }}" class="text-sm font-bold text-primary hover:underline">
                                Hapus pencarian
                            </a>
                        </div>
                    @endif
                    <!-- Filter Chips -->
                    <div class="flex flex-wrap justify-center gap-3">
                        @foreach(data_get($pageContent, 'filters.chips', []) as $idx => $chip)
                            @php
                                $isActiveChip = ($selectedCategory ?? '') === $chip
                                    || (($selectedCategory ?? '') === '' && $idx === 0)
                                    || (strtolower((string) ($selectedCategory ?? '')) === 'semua' && $idx === 0);
                                $chipParams = [];
                                if ($idx > 0) {
                                    $chipParams['category'] = $chip;
                                }
                                if (($searchQuery ?? '') !== '') {
                                    $chipParams['q'] = $searchQuery;
                                }
                                $chipUrl = $idx === 0
                                    ? route('courses', (($searchQuery ?? '') !== '') ? ['q' => $searchQuery] : [])
                                    : route('courses', $chipParams);
                            @endphp
                            @if($idx === 0)
                                <a href="{{ $chipUrl }}" class="{{ $isActiveChip ? 'active-filter bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-primary/10 hover:border-primary hover:text-primary' }} px-6 py-2.5 rounded-full font-label-md text-label-md transition-all border">{{ $chip }}</a>
                            @else
                                <a href="{{ $chipUrl }}" class="{{ $isActiveChip ? 'active-filter bg-primary text-white border-primary' : 'bg-white text-on-surface-variant border-primary/10 hover:border-primary hover:text-primary' }} px-6 py-2.5 rounded-full font-label-md text-label-md transition-all border">{{ $chip }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Course Grid -->
            <div id="list-kursus" class="scroll-mt-32 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-course-grid>
                @forelse($courses as $course)
                @include('pages.courses.partials.course-card', ['course' => $course, 'pageContent' => $pageContent])
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 text-on-surface-variant">
                    <span class="material-symbols-outlined text-6xl mb-4 opacity-50">school</span>
                    <p class="font-bold text-xl">{{ data_get($pageContent, 'grid.empty_state_title') }}</p>
                </div>
                @endforelse
            </div>

            <!-- Load More Button -->
            <div class="mt-12 text-center {{ $courses->hasMorePages() ? '' : 'hidden' }}" data-load-more-wrap>
                <button type="button" class="px-10 py-4 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary hover:text-white transition-all duration-300 shadow-sm active:scale-95" data-load-more-button data-next-url="{{ $courses->nextPageUrl() }}">
                    {{ data_get($pageContent, 'grid.load_more_label') }}
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter / CTA -->
    <!-- <section class="py-section-gap px-margin-mobile md:px-margin-desktop">
        <div class="max-w-container-max mx-auto">
            <div class="gradient-primary rounded-[40px] p-8 md:p-16 text-white text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg mb-6">{{ data_get($pageContent, 'newsletter.title') }}</h2>
                    <p class="font-body-lg text-body-lg opacity-90 max-w-2xl mx-auto mb-10">
                        {{ data_get($pageContent, 'newsletter.description') }}
                    </p>
                    <div class="flex flex-col md:flex-row justify-center items-center gap-4 max-w-lg mx-auto">
                        <input class="w-full px-6 py-4 rounded-full text-on-surface bg-white border-none focus:ring-4 focus:ring-secondary/50" placeholder="{{ data_get($pageContent, 'newsletter.email_placeholder') }}" type="email">
                        <button class="w-full md:w-auto px-8 py-4 rounded-full bg-white text-primary font-bold whitespace-nowrap hover:bg-opacity-90 transition-all">{{ data_get($pageContent, 'newsletter.button_label') }}</button>
                    </div>
                </div>
                <!-- Decorative Circles -->
                <div class="absolute -top-12 -left-12 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </section> -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loadMoreButton = document.querySelector('[data-load-more-button]');
            const loadMoreWrap = document.querySelector('[data-load-more-wrap]');
            const courseGrid = document.querySelector('[data-course-grid]');

            if (!loadMoreButton || !loadMoreWrap || !courseGrid) {
                return;
            }

            loadMoreButton.addEventListener('click', async () => {
                const nextUrl = loadMoreButton.dataset.nextUrl;

                if (!nextUrl || loadMoreButton.dataset.loading === 'true') {
                    return;
                }

                loadMoreButton.dataset.loading = 'true';
                const originalLabel = loadMoreButton.textContent.trim();
                loadMoreButton.disabled = true;
                loadMoreButton.textContent = 'Memuat...';

                try {
                    const response = await fetch(`${nextUrl}${nextUrl.includes('?') ? '&' : '?'}append=1`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        throw new Error('Gagal memuat kursus berikutnya.');
                    }

                    const data = await response.json();

                    if (data.html) {
                        courseGrid.insertAdjacentHTML('beforeend', data.html);
                    }

                    if (data.next_page_url) {
                        loadMoreButton.dataset.nextUrl = data.next_page_url;
                        loadMoreButton.disabled = false;
                        loadMoreButton.textContent = originalLabel;
                        loadMoreButton.dataset.loading = 'false';
                    } else {
                        loadMoreWrap.classList.add('hidden');
                    }
                } catch (error) {
                    console.error(error);
                    loadMoreButton.disabled = false;
                    loadMoreButton.textContent = originalLabel;
                    loadMoreButton.dataset.loading = 'false';
                }
            });
        });
    </script>
@endsection
