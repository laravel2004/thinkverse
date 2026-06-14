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
            {{ $course->level ?? data_get($pageContent, 'grid.default_level_label') }}
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
            <span class="text-xs font-bold text-primary/60 uppercase tracking-wider">{{ $course->category ?? data_get($pageContent, 'grid.default_category_label') }}</span>
            <a href="{{ route('courses.show', $course) }}" class="text-primary font-bold text-sm flex items-center group-hover:gap-2 transition-all">{{ data_get($pageContent, 'grid.detail_label') }} <span class="material-symbols-outlined text-[18px] ml-1">arrow_forward</span></a>
        </div>
    </div>
</article>
