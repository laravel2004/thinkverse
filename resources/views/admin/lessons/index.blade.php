@extends('layouts.admin')

@section('title', 'Materi: ' . $course->title)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
            <a href="{{ route('admin.courses.index') }}" class="hover:text-primary transition-colors">Kursus</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface">{{ $course->title }}</span>
        </div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Struktur Materi</h1>
        <p class="text-on-surface-variant font-medium mt-1">Kelola bab dan sub-bab untuk kursus ini.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Lesson Tree -->
    <div class="lg:col-span-2 space-y-4">
        @forelse($lessons as $chapter)
            <!-- Chapter Item -->
            <div class="bg-white rounded-3xl border border-primary/5 shadow-sm overflow-hidden" x-data="{ open: true }">
                <div class="flex items-center justify-between p-4 bg-surface/30">
                    <div class="flex items-center gap-3">
                        <button @click="open = !open" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-surface text-on-surface-variant transition-colors">
                            <span class="material-symbols-outlined text-[20px]" x-text="open ? 'expand_more' : 'chevron_right'"></span>
                        </button>
                        <div>
                            <h3 class="font-bold text-on-surface">{{ $chapter->title }}</h3>
                            <div class="flex gap-2 mt-1">
                                @if($chapter->status === 'published')
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-200">Published</span>
                                @else
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-200">Draft</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.lessons.edit', $chapter) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form action="{{ route('admin.lessons.destroy', $chapter) }}" method="POST" onsubmit="return confirm('Hapus bab ini dan semua isinya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Hapus">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sub-lessons List -->
                <div x-show="open" class="p-4 border-t border-primary/5 bg-white">
                    <div class="space-y-2 pl-4 border-l-2 border-primary/10 ml-4">
                        @foreach($chapter->children as $subLesson)
                            <div class="flex items-center justify-between p-3 bg-surface/20 rounded-2xl border border-primary/5 hover:bg-surface/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary/40">description</span>
                                    <div>
                                        <h4 class="font-bold text-sm text-on-surface">{{ $subLesson->title }}</h4>
                                        <div class="flex gap-2 mt-0.5">
                                            @if($subLesson->status === 'published')
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-green-600">Published</span>
                                            @else
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-gray-400">Draft</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.lessons.edit', $subLesson) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit_document</span>
                                    </a>
                                    <form action="{{ route('admin.lessons.destroy', $subLesson) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Add Sub-lesson Form Inline -->
                        <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" class="flex gap-2 mt-2">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $chapter->id }}">
                            <input type="text" name="title" placeholder="Judul sub-materi baru..." class="flex-1 text-sm px-3 py-2 bg-surface/50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
                            <button type="submit" class="px-4 py-2 bg-primary/10 text-primary font-bold text-sm rounded-xl hover:bg-primary hover:text-white transition-colors">
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-3xl border border-primary/5 text-center">
                <span class="material-symbols-outlined text-5xl text-on-surface-variant opacity-50 mb-4">account_tree</span>
                <h3 class="font-bold text-on-surface mb-1">Belum ada materi</h3>
                <p class="text-sm text-on-surface-variant">Mulai dengan menambahkan bab (Chapter) pertama di sebelah kanan.</p>
            </div>
        @endforelse
    </div>

    <!-- Right Column: Add Chapter Form -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-3xl border border-primary/5 shadow-sm sticky top-24">
            <h3 class="font-bold text-lg text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">add_box</span>
                Tambah Bab (Chapter)
            </h3>
            <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-bold text-on-surface mb-2">Judul Bab</label>
                    <input type="text" id="title" name="title" placeholder="Contoh: Pengenalan Dasar" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
                </div>
                <button type="submit" class="w-full py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                    Simpan Bab
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
