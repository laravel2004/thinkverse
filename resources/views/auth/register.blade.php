@extends('layouts.public')

@section('title', 'Daftar - ThinkVerse Premium')

@section('content')
    <section class="relative py-32 px-margin-mobile md:px-margin-desktop overflow-hidden min-h-screen flex items-center justify-center bg-gradient-to-br from-[#faf8ff] via-[#f4ecff] to-[#fce7f3]">
        <!-- Decorative Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute -top-[10%] -right-[10%] w-[800px] h-[800px] bg-gradient-to-bl from-[#7C3AED]/30 to-[#EC4899]/30 rounded-full blur-[120px] mix-blend-multiply animate-pulse" style="animation-duration: 10s;"></div>
            <div class="absolute -bottom-[10%] -left-[10%] w-[700px] h-[700px] bg-gradient-to-tr from-[#EC4899]/20 to-[#630ed4]/40 rounded-full blur-[150px] mix-blend-multiply animate-pulse" style="animation-duration: 14s;"></div>
        </div>

        <div class="w-full max-w-lg">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 rounded-full bg-white/50 border border-primary/10 text-primary text-xs font-extrabold backdrop-blur-sm shadow-sm">
                    BERGABUNG SEKARANG
                </div>
                <h1 class="font-display-lg text-4xl text-on-surface mb-4 leading-tight">
                    Mulai Perjalanan Anda <br/>di <span class="text-gradient">ThinkVerse</span>
                </h1>
                <p class="font-body-md text-on-surface-variant text-lg">Jadilah bagian dari komunitas pembelajar tanpa batas dan wujudkan impian karier Anda hari ini.</p>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 border border-primary/10 premium-shadow">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="font-label-md text-label-md text-on-surface-variant">Nama Lengkap</label>
                        <input id="name" class="w-full px-6 py-4 rounded-2xl bg-white border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('name') border-red-500 @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="font-label-md text-label-md text-on-surface-variant">Alamat Email</label>
                        <input id="email" class="w-full px-6 py-4 rounded-2xl bg-white border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('email') border-red-500 @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email@contoh.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="font-label-md text-label-md text-on-surface-variant">Kata Sandi</label>
                        <input id="password" class="w-full px-6 py-4 rounded-2xl bg-white border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('password') border-red-500 @enderror" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="font-label-md text-label-md text-on-surface-variant">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" class="w-full px-6 py-4 rounded-2xl bg-white border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('password_confirmation') border-red-500 @enderror" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <button type="submit" class="w-full deep-purple-gradient text-on-primary py-4 rounded-2xl font-bold text-lg shadow-[0_15px_30px_rgba(99,14,212,0.2)] purple-glow-hover transition-all active:scale-95 mt-4">
                        Daftar Akun
                    </button>
                </form>

                <p class="mt-8 text-center font-body-md text-sm text-on-surface-variant">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </section>
@endsection
