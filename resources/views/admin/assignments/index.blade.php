@extends('layouts.admin')

@section('title', 'Tugas: ' . $course->title)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
            <a href="{{ route('admin.courses.index') }}" class="hover:text-primary transition-colors">Kursus</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a href="{{ route('admin.courses.edit', $course) }}" class="hover:text-primary transition-colors">{{ $course->title }}</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface">Tugas</span>
        </div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Daftar Tugas</h1>
    </div>
    <a href="{{ route('admin.courses.assignments.create', $course) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
        <span class="material-symbols-outlined">add</span>
        Tugas Baru
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-3xl border border-primary/5 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-primary/5 bg-surface/50">
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Judul Tugas</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Terkait Materi</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Tenggat Waktu</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Status</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary/5">
                @forelse($assignments as $assignment)
                <tr class="hover:bg-surface/30 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-bold text-on-surface">{{ $assignment->title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($assignment->lesson)
                            <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold">
                                {{ $assignment->lesson->title }}
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 bg-surface text-on-surface-variant rounded-full text-xs font-bold">
                                Umum (Level Kursus)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($assignment->due_at)
                            <span class="text-sm {{ $assignment->due_at->isPast() ? 'text-red-500 font-bold' : 'text-on-surface' }}">
                                {{ $assignment->due_at->format('d M Y, H:i') }}
                            </span>
                        @else
                            <span class="text-sm text-on-surface-variant italic">Tanpa Tenggat</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($assignment->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-bold border border-gray-200">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.assignments.submissions.index', $assignment) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center" title="Reviu Pengumpulan">
                                <span class="material-symbols-outlined text-[20px]">grading</span>
                            </a>
                            <a href="{{ route('admin.assignments.edit', $assignment) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 hover:bg-orange-600 hover:text-white transition-colors flex items-center justify-center" title="Edit Tugas">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors flex items-center justify-center" title="Hapus Tugas">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-5xl mb-4 opacity-50">assignment</span>
                        <p class="font-medium">Belum ada tugas untuk kursus ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
