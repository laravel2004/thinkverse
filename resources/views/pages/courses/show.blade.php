@extends('layouts.public')

@section('title', $course->title . ' - ThinkVerse Premium')

@section('content')
<!-- Hero Section -->
<section class="relative pt-24 pb-16 px-margin-mobile md:px-margin-desktop overflow-hidden bg-surface">
    <div class="absolute inset-0 bg-primary/5"></div>
    <div class="max-w-container-max mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <div class="flex items-center gap-3 mb-6">
                <span class="px-3 py-1 bg-primary/10 text-primary font-bold text-xs rounded-full uppercase tracking-wider">{{ $course->category ?? 'Umum' }}</span>
                <span class="px-3 py-1 bg-white border border-primary/10 text-on-surface-variant font-bold text-xs rounded-full uppercase tracking-wider">{{ $course->level ?? 'Semua Level' }}</span>
            </div>
            <h1 class="font-display-lg text-4xl md:text-5xl lg:text-6xl text-on-surface mb-6 leading-tight">
                {{ $course->title }}
            </h1>
            <p class="font-body-lg text-lg text-on-surface-variant mb-8 max-w-xl">
                {{ $course->excerpt ?? Str::limit($course->description, 150) }}
            </p>
            <div class="flex flex-wrap gap-4">
                @if($firstLesson)
                    <a href="{{ route('courses.lesson', [$course, $firstLesson]) }}" class="px-8 py-4 rounded-full bg-primary text-white font-bold hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                        <span class="material-symbols-outlined">play_circle</span>
                        Mulai Belajar
                    </a>
                @else
                    <button disabled class="px-8 py-4 rounded-full bg-surface text-on-surface-variant font-bold border border-primary/10 cursor-not-allowed">
                        Belum Ada Materi
                    </button>
                @endif
            </div>
        </div>
        <div class="relative">
            <div class="aspect-video rounded-[32px] overflow-hidden shadow-2xl relative border-8 border-white bg-surface">
                @if($course->thumbnail_path)
                    <img class="w-full h-full object-cover" alt="{{ $course->title }}" src="{{ Storage::url($course->thumbnail_path) }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-primary/30 bg-surface">
                        <span class="material-symbols-outlined text-8xl">school</span>
                    </div>
                @endif
            </div>
            <!-- Decorative Element -->
            <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-secondary-fixed rounded-3xl -z-10 blur-xl opacity-60"></div>
            <div class="absolute -top-6 -right-6 w-48 h-48 bg-primary-fixed rounded-full -z-10 blur-2xl opacity-40"></div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 px-margin-mobile md:px-margin-desktop bg-white">
    <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-12">
            <!-- Deskripsi -->
            <div>
                <h2 class="font-display-md text-2xl font-bold text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    Tentang Kursus Ini
                </h2>
                <div class="prose prose-lg max-w-none text-on-surface-variant">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>

            <!-- Silabus -->
            <div>
                <h2 class="font-display-md text-2xl font-bold text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                    Silabus Materi
                </h2>
                <div class="bg-surface rounded-3xl border border-primary/10 overflow-hidden">
                    @forelse($course->lessons->whereNull('parent_id') as $index => $chapter)
                        <div class="border-b border-primary/5 last:border-0">
                            <a href="{{ route('courses.lesson', [$course, $chapter]) }}" class="px-6 py-4 bg-white/50 flex items-center justify-between gap-4 hover:bg-surface/50 transition-colors group">
                                <div class="min-w-0">
                                    <h3 class="font-bold text-on-surface group-hover:text-primary transition-colors">Bab {{ $index + 1 }}: {{ $chapter->title }}</h3>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if(($chapter->active_assignments_count ?? 0) > 0)
                                        <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Tugas</span>
                                    @endif
                                    <span class="text-xs font-bold text-on-surface-variant">{{ $chapter->children->count() }} Sub-bab</span>
                                    <span class="material-symbols-outlined text-primary/40 group-hover:text-primary transition-colors">chevron_right</span>
                                </div>
                            </a>
                            @if($chapter->children->count() > 0)
                                <div class="divide-y divide-primary/5 bg-white">
                                    @foreach($chapter->children as $subLesson)
                                        <a href="{{ route('courses.lesson', [$course, $subLesson]) }}" class="px-8 py-4 flex items-center justify-between hover:bg-surface/50 transition-colors group">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-primary/40 group-hover:text-primary transition-colors">play_circle</span>
                                                <span class="text-on-surface-variant group-hover:text-primary transition-colors font-medium">{{ $subLesson->title }}</span>
                                            </div>
                                            @if(($subLesson->active_assignments_count ?? 0) > 0)
                                                <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-1 rounded-full flex-shrink-0">Tugas</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-on-surface-variant">
                            Belum ada materi untuk kursus ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-primary/10 shadow-sm sticky top-24">
                <h3 class="font-bold text-lg text-on-surface mb-6">Informasi Kursus</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">category</span>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Kategori</p>
                            <p class="text-sm text-on-surface-variant">{{ $course->category ?? 'Umum' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">school</span>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Level</p>
                            <p class="text-sm text-on-surface-variant">{{ $course->level ?? 'Semua Level' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">book</span>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Materi</p>
                            <p class="text-sm text-on-surface-variant">{{ $course->lessons->count() }} Modul</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">update</span>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Terakhir Diperbarui</p>
                            <p class="text-sm text-on-surface-variant">{{ $course->updated_at->diffForHumans() }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
