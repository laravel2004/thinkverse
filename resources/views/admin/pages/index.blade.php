@extends('layouts.admin')

@section('title', 'Kelola Konten Halaman')

@section('content')
<div class="mb-6">
    <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Kelola Konten Halaman</h1>
    <p class="text-on-surface-variant font-medium mt-1">Kelola teks, gambar, dan tautan pemasaran untuk setiap halaman publik.</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($pages as $key => $title)
    <div class="bg-white p-6 rounded-[2rem] border border-primary/5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-4">
                @if($key === 'home')
                    <span class="material-symbols-outlined">home</span>
                @elseif($key === 'about')
                    <span class="material-symbols-outlined">info</span>
                @elseif($key === 'contact')
                    <span class="material-symbols-outlined">contact_support</span>
                @elseif($key === 'courses')
                    <span class="material-symbols-outlined">menu_book</span>
                @endif
            </div>
            <h2 class="text-xl font-bold text-on-surface">{{ $title }} <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded ml-2">{{ $key }}</span></h2>
            <p class="text-sm text-on-surface-variant mt-2">
                @if($key === 'home')
                    Kelola bagian Hero, Founder Profile, Fitur Unggulan, dan Preview katalog kursus.
                @elseif($key === 'about')
                    Kelola judul halaman, badge visi misi, deskripsi, dan foto tim ThinkVerse.
                @elseif($key === 'contact')
                    Kelola informasi alamat kantor, email, telepon, jam operasional, serta form.
                @elseif($key === 'courses')
                    Kelola section hero, teks filter, empty state, tombol load-more, dan newsletter.
                @endif
            </p>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.pages.edit', $key) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary/5 text-primary hover:bg-primary hover:text-white transition-all rounded-2xl font-bold">
                <span class="material-symbols-outlined text-[20px]">edit</span>
                Edit Konten
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
