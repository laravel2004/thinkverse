@extends('layouts.admin')

@section('title', 'Edit Halaman Kontak')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
        <a href="{{ route('admin.pages.index') }}" class="hover:text-primary transition-colors">Konten Halaman</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-on-surface">Contact</span>
    </div>
    <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Edit Halaman Hubungi Kami (Contact)</h1>
    <p class="text-on-surface-variant font-medium mt-1">Ubah konten hero kontak dan informasi kartu kontak.</p>
</div>

<form action="{{ route('admin.pages.update', 'contact') }}" method="POST" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- HERO SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">contact_support</span>
            Section 1: Hero Halaman
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Meta Title Halaman</label>
                <input type="text" name="sections[hero][page_title]" value="{{ old('sections.hero.page_title', data_get($content, 'hero.page_title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Deskripsi Hero</label>
                <textarea name="sections[hero][description]" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface resize-y" required>{{ old('sections.hero.description', data_get($content, 'hero.description')) }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Sebelum Highlight</label>
                <input type="text" name="sections[hero][title_before_highlight]" value="{{ old('sections.hero.title_before_highlight', data_get($content, 'hero.title_before_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface">
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Title Highlighted Text</label>
                <input type="text" name="sections[hero][title_highlight]" value="{{ old('sections.hero.title_highlight', data_get($content, 'hero.title_highlight')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>
    </div>

    <!-- INFO CARDS SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">info</span>
            Section 2: Kartu Informasi Kontak
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach(data_get($content, 'info.cards', []) as $idx => $card)
            <div class="p-4 bg-surface/50 rounded-2xl border border-primary/5 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-primary/5">
                    <span class="text-xs font-bold text-primary">Kartu {{ $idx + 1 }}</span>
                    <input type="text" name="sections[info][cards][{{ $idx }}][icon]" value="{{ $card['icon'] }}" class="w-20 px-2 py-1 bg-white border-none rounded-lg text-xs" placeholder="Icon" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Judul Kartu</label>
                    <input type="text" name="sections[info][cards][{{ $idx }}][title]" value="{{ $card['title'] }}" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs" required>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Baris Teks Detail (Satu per baris)</label>
                    <textarea name="sections[info][cards][{{ $idx }}][lines_text]" rows="3" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs resize-y" required>{{ implode("\n", $card['lines'] ?? []) }}</textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Label Tautan (Optional)</label>
                    <input type="text" name="sections[info][cards][{{ $idx }}][link_label]" value="{{ $card['link_label'] ?? '' }}" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-on-surface-variant mb-1">Tautan URL (Optional)</label>
                    <input type="text" name="sections[info][cards][{{ $idx }}][link_url]" value="{{ $card['link_url'] ?? '' }}" class="w-full px-3 py-2 bg-white border-none rounded-xl text-xs">
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- FORM CONFIG SECTION -->
    <div class="bg-white rounded-[2rem] border border-primary/5 shadow-sm p-6 lg:p-8 space-y-6">
        <h2 class="text-xl font-bold text-primary flex items-center gap-2 pb-4 border-b border-primary/5">
            <span class="material-symbols-outlined">mail</span>
            Section 3: Konfigurasi Form Kirim Pesan (Visual Saja)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Judul Form</label>
                <input type="text" name="sections[form][title]" value="{{ old('sections.form.title', data_get($content, 'form.title')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Label Tombol Kirim</label>
                <input type="text" name="sections[form][button_label]" value="{{ old('sections.form.button_label', data_get($content, 'form.button_label')) }}" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-4 bg-white p-6 rounded-3xl border border-primary/5 shadow-sm">
        <a href="{{ route('admin.pages.index') }}" class="px-6 py-3 text-on-surface-variant hover:text-on-surface font-bold transition-colors">
            Batal
        </a>
        <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
