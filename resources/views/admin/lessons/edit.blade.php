@extends('layouts.admin')

@section('title', 'Content Builder: ' . $lesson->title)

@section('content')
<!-- Include Quill JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
            <a href="{{ route('admin.courses.index') }}" class="hover:text-primary transition-colors">Kursus</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a href="{{ route('admin.courses.lessons.index', $lesson->course_id) }}" class="hover:text-primary transition-colors">{{ $lesson->course->title }}</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface">{{ $lesson->title }}</span>
        </div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Content Builder</h1>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <!-- Left Column: Content Builder -->
    <div class="xl:col-span-2 space-y-6">
        
        <!-- Render Existing Blocks -->
        <div class="space-y-4">
            @forelse($lesson->contentBlocks as $index => $block)
                <div class="bg-white rounded-3xl border border-primary/5 shadow-sm p-6 group">
                    <div class="flex items-center justify-between mb-4 border-b border-primary/5 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-surface flex items-center justify-center font-bold text-sm text-on-surface-variant">{{ $index + 1 }}</span>
                            <span class="font-bold text-primary uppercase text-xs tracking-wider bg-primary/10 px-3 py-1 rounded-full">{{ $block->type }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.blocks.destroy', $block) }}" method="POST" onsubmit="return confirm('Hapus blok ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors opacity-0 group-hover:opacity-100">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.blocks.update', $block) }}" method="POST" id="form-block-{{ $block->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if($block->type === 'text')
                            <div class="quill-editor bg-white" id="editor-{{ $block->id }}">{!! $block->payload['content'] ?? '' !!}</div>
                            <input type="hidden" name="payload[content]" id="input-{{ $block->id }}" value="{{ $block->payload['content'] ?? '' }}">
                        @elseif($block->type === 'code')
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1 block">Bahasa Pemrograman</label>
                                    <input type="text" name="payload[language]" value="{{ $block->payload['language'] ?? 'php' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm font-mono">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1 block">Kode</label>
                                    <textarea name="payload[code]" rows="5" class="w-full px-4 py-3 bg-[#1e1e1e] text-[#d4d4d4] font-mono text-sm border-none rounded-xl">{{ $block->payload['code'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @elseif($block->type === 'notice')
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1 block">Tipe (info/warning/success)</label>
                                    <select name="payload[type]" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm">
                                        <option value="info" {{ ($block->payload['type'] ?? '') == 'info' ? 'selected' : '' }}>Info</option>
                                        <option value="warning" {{ ($block->payload['type'] ?? '') == 'warning' ? 'selected' : '' }}>Warning</option>
                                        <option value="success" {{ ($block->payload['type'] ?? '') == 'success' ? 'selected' : '' }}>Success</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1 block">Pesan</label>
                                    <textarea name="payload[message]" rows="3" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm">{{ $block->payload['message'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @elseif($block->type === 'link')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Teks Link</label>
                                    <input type="text" name="payload[text]" value="{{ $block->payload['text'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">URL</label>
                                    <input type="url" name="payload[url]" value="{{ $block->payload['url'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" required>
                                </div>
                            </div>
                        @elseif($block->type === 'button')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Teks Tombol</label>
                                    <input type="text" name="payload[text]" value="{{ $block->payload['text'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">URL</label>
                                    <input type="url" name="payload[url]" value="{{ $block->payload['url'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Gaya Tombol</label>
                                    <select name="payload[style]" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" required>
                                        <option value="primary" {{ ($block->payload['style'] ?? '') === 'primary' ? 'selected' : '' }}>Primary (Solid)</option>
                                        <option value="outline" {{ ($block->payload['style'] ?? '') === 'outline' ? 'selected' : '' }}>Outline (Garis Tepi)</option>
                                    </select>
                                </div>
                            </div>
                        @elseif($block->type === 'youtube')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">URL YouTube</label>
                                    <input type="url" name="payload[url]" value="{{ $block->payload['url'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" placeholder="https://www.youtube.com/watch?v=..." required>
                                </div>
                            </div>
                        @elseif($block->type === 'pdf')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Upload PDF Baru (Opsional)</label>
                                    <input type="file" name="payload[file]" accept=".pdf" class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary">
                                    @if(isset($block->payload['file_path']))
                                        <div class="mt-2 text-sm text-primary font-bold"><a href="{{ Storage::url($block->payload['file_path']) }}" target="_blank">Lihat PDF Saat Ini</a></div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Judul Dokumen</label>
                                    <input type="text" name="payload[title]" value="{{ $block->payload['title'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm" required>
                                </div>
                            </div>
                        @elseif($block->type === 'image')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Upload Gambar Baru (Opsional)</label>
                                    <input type="file" name="payload[file]" accept="image/*" class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary">
                                    @if(isset($block->payload['file_path']))
                                        <div class="mt-2"><img src="{{ Storage::url($block->payload['file_path']) }}" class="h-20 rounded-lg shadow-md"></div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Caption (Opsional)</label>
                                    <input type="text" name="payload[caption]" value="{{ $block->payload['caption'] ?? '' }}" class="w-full px-4 py-2 bg-surface border-none rounded-xl text-sm">
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 flex justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                            <button type="button" onclick="saveBlock({{ $block->id }}, '{{ $block->type }}')" class="px-4 py-2 bg-primary text-white font-bold text-sm rounded-xl">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="bg-surface/50 border-2 border-dashed border-primary/20 rounded-3xl p-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-primary/40 mb-4">note_stack</span>
                    <h3 class="font-bold text-lg text-on-surface">Materi Kosong</h3>
                    <p class="text-on-surface-variant mt-2">Tambahkan blok teks, kode, atau info di bawah ini untuk mulai menyusun materi.</p>
                </div>
            @endforelse
        </div>

        <!-- Add New Block Panel -->
        <div class="bg-primary/5 rounded-3xl border border-primary/10 p-6" x-data="{ activeTab: 'text' }">
            <h3 class="font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">add_circle</span>
                Tambah Blok Baru
            </h3>
            
            <div class="flex flex-wrap gap-2 mb-6">
                <button @click="activeTab = 'text'" :class="activeTab === 'text' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">format_align_left</span> Teks
                </button>
                <button @click="activeTab = 'code'" :class="activeTab === 'code' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">code</span> Kode
                </button>
                <button @click="activeTab = 'notice'" :class="activeTab === 'notice' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">info</span> Notis
                </button>
                <button @click="activeTab = 'link'" :class="activeTab === 'link' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">link</span> Link
                </button>
                <button @click="activeTab = 'button'" :class="activeTab === 'button' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">smart_button</span> Button
                </button>
                <button @click="activeTab = 'pdf'" :class="activeTab === 'pdf' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span> PDF
                </button>
                <button @click="activeTab = 'image'" :class="activeTab === 'image' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">image</span> Gambar
                </button>
                <button @click="activeTab = 'youtube'" :class="activeTab === 'youtube' ? 'bg-primary text-white shadow-md' : 'bg-white text-on-surface-variant hover:bg-surface'" class="px-4 py-2 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">smart_display</span> YouTube
                </button>
            </div>

            <!-- Text Form -->
            <form x-show="activeTab === 'text'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" id="form-new-text">
                @csrf
                <input type="hidden" name="type" value="text">
                <div class="bg-white rounded-xl overflow-hidden mb-4 border border-primary/10">
                    <div id="editor-new-text" class="bg-white min-h-[200px]"></div>
                </div>
                <input type="hidden" name="payload[content]" id="input-new-text">
                <button type="button" onclick="saveNewText()" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Tambah Blok Teks</button>
            </form>

            <!-- Code Form -->
            <form x-show="activeTab === 'code'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="code">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold mb-2">Bahasa</label>
                        <input type="text" name="payload[language]" placeholder="php, js, html..." class="w-full px-4 py-3 bg-white border-none rounded-xl focus:ring-2 text-sm font-mono" required>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-bold mb-2">Snippet Kode</label>
                        <textarea name="payload[code]" rows="5" class="w-full px-4 py-3 bg-[#1e1e1e] text-[#d4d4d4] font-mono text-sm border-none rounded-xl focus:ring-2" required></textarea>
                    </div>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Tambah Blok Kode</button>
            </form>

            <!-- Notice Form -->
            <form x-show="activeTab === 'notice'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="notice">
                <div>
                    <label class="block text-sm font-bold mb-2">Tipe Notis</label>
                    <select name="payload[type]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm" required>
                        <option value="info">Info (Biru)</option>
                        <option value="warning">Warning (Kuning)</option>
                        <option value="success">Success (Hijau)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Pesan</label>
                    <textarea name="payload[message]" rows="3" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" required></textarea>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Tambah Blok Notis</button>
            </form>

            <!-- Link Form -->
            <form x-show="activeTab === 'link'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="link">
                <div>
                    <label class="block text-sm font-bold mb-2">Teks Link</label>
                    <input type="text" name="payload[text]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">URL</label>
                    <input type="url" name="payload[url]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" placeholder="https://" required>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Tambah Link</button>
            </form>

            <!-- Button Form -->
            <form x-show="activeTab === 'button'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="button">
                <div>
                    <label class="block text-sm font-bold mb-2">Teks Tombol</label>
                    <input type="text" name="payload[text]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">URL</label>
                    <input type="url" name="payload[url]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" placeholder="https://" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Gaya Tombol</label>
                    <select name="payload[style]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm" required>
                        <option value="primary">Primary (Solid)</option>
                        <option value="outline">Outline (Garis Tepi)</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Tambah Tombol</button>
            </form>

            <!-- PDF Form -->
            <form x-show="activeTab === 'pdf'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" enctype="multipart/form-data" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="pdf">
                <div>
                    <label class="block text-sm font-bold mb-2">Judul Dokumen</label>
                    <input type="text" name="payload[title]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Upload File PDF</label>
                    <input type="file" name="payload[file]" accept=".pdf" class="w-full bg-white p-3 rounded-xl border border-primary/10 text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Upload PDF</button>
            </form>

            <!-- Image Form -->
            <form x-show="activeTab === 'image'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" enctype="multipart/form-data" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="image">
                <div>
                    <label class="block text-sm font-bold mb-2">Upload Gambar</label>
                    <input type="file" name="payload[file]" accept="image/*" class="w-full bg-white p-3 rounded-xl border border-primary/10 text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Caption (Opsional)</label>
                    <input type="text" name="payload[caption]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2">
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Upload Gambar</button>
            </form>

            <!-- YouTube Form -->
            <form x-show="activeTab === 'youtube'" action="{{ route('admin.lessons.blocks.store', $lesson) }}" method="POST" class="space-y-4" style="display: none;">
                @csrf
                <input type="hidden" name="type" value="youtube">
                <div>
                    <label class="block text-sm font-bold mb-2">URL YouTube</label>
                    <input type="url" name="payload[url]" class="w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2" placeholder="https://www.youtube.com/watch?v=..." required>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Embed YouTube</button>
            </form>
        </div>
    </div>

    <!-- Right Column: Lesson Settings -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-3xl border border-primary/5 shadow-sm sticky top-24">
            <h3 class="font-bold text-lg text-on-surface mb-4 border-b border-primary/5 pb-4">Pengaturan Materi</h3>
            <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Judul Materi</label>
                    <input type="text" name="title" value="{{ $lesson->title }}" class="w-full px-4 py-3 bg-surface border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Status Publikasi</label>
                    <select name="status" class="w-full px-4 py-3 bg-surface border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface">
                        <option value="draft" {{ $lesson->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                        <option value="published" {{ $lesson->status === 'published' ? 'selected' : '' }}>Published (Tampilkan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Ringkasan (Opsional)</label>
                    <textarea name="excerpt" rows="3" class="w-full px-4 py-3 bg-surface border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface">{{ $lesson->excerpt }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors">
                    Perbarui Pengaturan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Quill Editors
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],
        ['clean']                                         // remove formatting button
    ];

    var editors = {};

    // For existing text blocks
    @foreach($lesson->contentBlocks as $block)
        @if($block->type === 'text')
            editors[{{ $block->id }}] = new Quill('#editor-{{ $block->id }}', {
                theme: 'snow',
                modules: { toolbar: toolbarOptions }
            });
        @endif
    @endforeach

    // For new text block
    var newEditor = new Quill('#editor-new-text', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions },
        placeholder: 'Mulai menulis materi di sini...'
    });

    function saveBlock(id, type) {
        var form = document.getElementById('form-block-' + id);
        if(type === 'text') {
            document.getElementById('input-' + id).value = editors[id].root.innerHTML;
        }
        form.submit();
    }

    function saveNewText() {
        var html = newEditor.root.innerHTML;
        if(html === '<p><br></p>') {
            alert('Konten tidak boleh kosong!');
            return;
        }
        document.getElementById('input-new-text').value = html;
        document.getElementById('form-new-text').submit();
    }
</script>
<style>
    .ql-toolbar {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        border-color: rgba(99, 102, 241, 0.1) !important;
        background-color: #f8fafc;
    }
    .ql-container {
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-color: rgba(99, 102, 241, 0.1) !important;
        font-family: inherit !important;
        font-size: 1rem !important;
    }
    .ql-editor {
        min-height: 150px;
    }
</style>
@endsection
