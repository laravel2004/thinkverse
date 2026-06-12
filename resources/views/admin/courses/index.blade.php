@extends('layouts.admin')

@section('title', 'Daftar Kursus')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Manajemen Kursus</h1>
        <p class="text-on-surface-variant font-medium mt-1">Kelola semua materi pembelajaran di platform Anda.</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
        <span class="material-symbols-outlined">add</span>
        Kursus Baru
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<!-- Filters -->
<div class="bg-white p-4 rounded-3xl border border-primary/5 shadow-sm mb-6 flex flex-col md:flex-row gap-4">
    <form action="{{ route('admin.courses.index') }}" method="GET" class="flex-1 flex gap-4">
        <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul kursus..." class="w-full pl-12 pr-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-on-surface-variant">
        </div>
        <select name="status" class="px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface w-40">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit" class="px-6 py-3 bg-surface text-on-surface hover:text-primary font-bold rounded-2xl transition-colors">
            Filter
        </button>
    </form>
</div>

<!-- Courses List -->
<div class="bg-white rounded-3xl border border-primary/5 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-primary/5 bg-surface/50">
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Kursus</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Kategori</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Status</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary/5">
                @forelse($courses as $course)
                <tr class="hover:bg-surface/30 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($course->thumbnail_path)
                                <img src="{{ Storage::url($course->thumbnail_path) }}" alt="{{ $course->title }}" class="w-16 h-12 object-cover rounded-xl border border-primary/10">
                            @else
                                <div class="w-16 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary border border-primary/5">
                                    <span class="material-symbols-outlined">image</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-on-surface">{{ $course->title }}</h3>
                                <p class="text-xs text-on-surface-variant mt-0.5">Order: {{ $course->sort_order }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 bg-surface text-on-surface-variant rounded-full text-xs font-bold">
                            {{ $course->category ?? 'Umum' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($course->status === 'published')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-bold border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.courses.assignments.index', $course) }}" class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white transition-colors flex items-center justify-center" title="Kelola Tugas">
                                <span class="material-symbols-outlined text-[20px]">assignment</span>
                            </a>
                            <a href="{{ route('admin.courses.lessons.index', $course) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Kelola Materi/Sub-Bab">
                                <span class="material-symbols-outlined text-[20px]">list_alt</span>
                            </a>
                            <a href="{{ route('admin.courses.edit', $course) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-colors flex items-center justify-center" title="Edit Kursus">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini beserta seluruh materinya?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center" title="Hapus Kursus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-5xl mb-4 opacity-50">inventory_2</span>
                        <p class="font-medium">Belum ada kursus yang dibuat.</p>
                        <a href="{{ route('admin.courses.create') }}" class="text-primary hover:underline font-bold mt-2 inline-block">Buat Kursus Pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($courses->hasPages())
    <div class="p-6 border-t border-primary/5">
        {{ $courses->links() }}
    </div>
    @endif
</div>
@endsection
