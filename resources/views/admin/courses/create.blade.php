@extends('layouts.admin')

@section('title', isset($course) ? 'Edit Kursus' : 'Buat Kursus Baru')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
            <a href="{{ route('admin.courses.index') }}" class="hover:text-primary transition-colors">Kursus</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface">{{ isset($course) ? 'Edit' : 'Buat Baru' }}</span>
        </div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">{{ isset($course) ? 'Edit Kursus' : 'Buat Kursus Baru' }}</h1>
    </div>
</div>

<div class="bg-white rounded-3xl border border-primary/5 shadow-sm overflow-hidden">
    <form action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="p-6 lg:p-8">
        @csrf
        @if(isset($course))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-on-surface mb-2">Judul Kursus</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $course->title ?? '') }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
                    @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-bold text-on-surface mb-2">Slug (URL)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $course->slug ?? '') }}" placeholder="Dikosongkan akan terisi otomatis" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-on-surface-variant/50">
                    <p class="mt-1 text-xs text-on-surface-variant">Contoh: judul-kursus-keren</p>
                    @error('slug') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-bold text-on-surface mb-2">Ringkasan (Excerpt)</label>
                    <textarea id="excerpt" name="excerpt" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y">{{ old('excerpt', $course->excerpt ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-on-surface-variant">Ringkasan singkat yang muncul di kartu kursus.</p>
                    @error('excerpt') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-on-surface mb-2">Deskripsi Lengkap</label>
                    <textarea id="description" name="description" rows="6" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y">{{ old('description', $course->description ?? '') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Sidebar Area -->
            <div class="space-y-6">
                <!-- Thumbnail -->
                <div class="bg-surface/50 p-6 rounded-3xl border border-primary/5">
                    <label class="block text-sm font-bold text-on-surface mb-4">Thumbnail Kursus</label>
                    
                    @if(isset($course) && $course->thumbnail_path)
                        <div class="mb-4">
                            <img src="{{ Storage::url($course->thumbnail_path) }}" alt="Thumbnail" class="w-full h-40 object-cover rounded-xl border border-primary/10">
                        </div>
                    @endif

                    <div class="relative group cursor-pointer">
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full h-32 border-2 border-dashed border-primary/20 bg-white rounded-2xl flex flex-col items-center justify-center text-on-surface-variant group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                            <span class="material-symbols-outlined text-3xl mb-2">add_photo_alternate</span>
                            <span class="text-sm font-medium">Klik untuk Upload</span>
                        </div>
                    </div>
                    @error('thumbnail') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Attributes -->
                <div class="bg-surface/50 p-6 rounded-3xl border border-primary/5 space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-bold text-on-surface mb-2">Status Publikasi</label>
                        <select id="status" name="status" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium">
                            <option value="draft" {{ old('status', $course->status ?? '') === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                            <option value="published" {{ old('status', $course->status ?? '') === 'published' ? 'selected' : '' }}>Published (Tampilkan)</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-on-surface mb-2">Kategori</label>
                        <input type="text" id="category" name="category" value="{{ old('category', $course->category ?? '') }}" placeholder="Contoh: Pemrograman" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-bold text-on-surface mb-2">Tingkat</label>
                        <select id="level" name="level" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
                            <option value="Pemula" {{ old('level', $course->level ?? '') === 'Pemula' ? 'selected' : '' }}>Pemula</option>
                            <option value="Menengah" {{ old('level', $course->level ?? '') === 'Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Mahir" {{ old('level', $course->level ?? '') === 'Mahir' ? 'selected' : '' }}>Mahir</option>
                        </select>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-bold text-on-surface mb-2">Urutan Tampil</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $course->sort_order ?? 0) }}" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-primary/5 flex items-center justify-end gap-4">
            <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 text-on-surface-variant hover:text-on-surface font-bold transition-colors">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                Simpan Kursus
            </button>
        </div>
    </form>
</div>
@endsection
