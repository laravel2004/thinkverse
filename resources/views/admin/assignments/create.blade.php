@extends('layouts.admin')

@section('title', isset($assignment) ? 'Edit Tugas' : 'Buat Tugas Baru')

@section('content')
<!-- Include Quill JS for Instruction -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
            <a href="{{ route('admin.courses.index') }}" class="hover:text-primary transition-colors">Kursus</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a href="{{ route('admin.courses.assignments.index', $course) }}" class="hover:text-primary transition-colors">{{ $course->title }}</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface">{{ isset($assignment) ? 'Edit Tugas' : 'Buat Baru' }}</span>
        </div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">{{ isset($assignment) ? 'Edit Tugas' : 'Buat Tugas Baru' }}</h1>
    </div>
</div>

<div class="bg-white rounded-3xl border border-primary/5 shadow-sm overflow-hidden">
    <form action="{{ isset($assignment) ? route('admin.assignments.update', $assignment) : route('admin.courses.assignments.store', $course) }}" method="POST" id="assignmentForm" class="p-6 lg:p-8">
        @csrf
        @if(isset($assignment))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-on-surface mb-2">Judul Tugas</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $assignment->title ?? '') }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
                </div>

                <!-- Instruction -->
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Instruksi Tugas</label>
                    <div class="bg-white rounded-xl overflow-hidden border border-primary/10">
                        <div id="editor-instruction" class="bg-white min-h-[200px]">{!! old('instruction', $assignment->instruction ?? '') !!}</div>
                    </div>
                    <input type="hidden" name="instruction" id="input-instruction">
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-surface/50 p-6 rounded-3xl border border-primary/5 space-y-4">
                    <!-- Lesson Association -->
                    <div>
                        <label for="lesson_id" class="block text-sm font-bold text-on-surface mb-2">Kaitkan dengan Materi</label>
                        <select id="lesson_id" name="lesson_id" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
                            <option value="">Umum (Seluruh Kursus)</option>
                            @foreach($course->lessons()->orderBy('sort_order')->get() as $lesson)
                                <option value="{{ $lesson->id }}" {{ (old('lesson_id', $assignment->lesson_id ?? '') == $lesson->id) ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_at" class="block text-sm font-bold text-on-surface mb-2">Tenggat Waktu</label>
                        <input type="datetime-local" id="due_at" name="due_at" value="{{ old('due_at', isset($assignment) && $assignment->due_at ? $assignment->due_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
                        <p class="mt-1 text-xs text-on-surface-variant">Kosongkan jika tanpa tenggat waktu.</p>
                    </div>

                    <!-- Is Active -->
                    <div class="pt-4 border-t border-primary/5">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $assignment->is_active ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded bg-white border-none text-primary focus:ring-primary/20">
                            <span class="text-sm font-bold text-on-surface">Tugas Aktif (Bisa dikerjakan)</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-primary/5 flex justify-end gap-4">
            <a href="{{ route('admin.courses.assignments.index', $course) }}" class="px-6 py-3 text-on-surface-variant font-bold hover:text-on-surface">Batal</a>
            <button type="button" onclick="saveAssignment()" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 shadow-lg shadow-primary/20">Simpan Tugas</button>
        </div>
    </form>
</div>

<script>
    var quill = new Quill('#editor-instruction', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    function saveAssignment() {
        var html = quill.root.innerHTML;
        if(html === '<p><br></p>') html = '';
        document.getElementById('input-instruction').value = html;
        document.getElementById('assignmentForm').submit();
    }
</script>
<style>
    .ql-toolbar { border-radius: 0.75rem 0.75rem 0 0; border-color: rgba(99, 102, 241, 0.1) !important; background-color: #f8fafc; }
    .ql-container { border-radius: 0 0 0.75rem 0.75rem; border-color: rgba(99, 102, 241, 0.1) !important; font-family: inherit !important; font-size: 1rem !important; }
</style>
@endsection
