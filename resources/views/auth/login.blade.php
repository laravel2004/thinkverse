@extends('layouts.public')

@section('title', 'Login - ThinkVerse Premium')

@section('content')
    <section class="relative py-32 px-margin-mobile md:px-margin-desktop overflow-hidden min-h-screen flex items-center justify-center bg-gradient-to-br from-[#faf8ff] via-[#f4ecff] to-[#fce7f3]">
        <!-- Decorative Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute -top-[10%] -left-[10%] w-[700px] h-[700px] bg-gradient-to-br from-[#7C3AED]/40 to-[#EC4899]/30 rounded-full blur-[120px] mix-blend-multiply animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[800px] h-[800px] bg-gradient-to-tl from-[#EC4899]/20 to-[#630ed4]/30 rounded-full blur-[150px] mix-blend-multiply animate-pulse" style="animation-duration: 12s;"></div>
        </div>

        <div class="w-full max-w-md">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 rounded-full bg-white/50 border border-primary/10 text-primary text-xs font-extrabold backdrop-blur-sm shadow-sm">
                    AKSES ADMIN
                </div>
                <h1 class="font-display-lg text-4xl text-on-surface mb-4 leading-tight">
                    Masuk ke <br/><span class="text-gradient">Admin Panel</span>
                </h1>
                <p class="font-body-md text-on-surface-variant text-lg">Halaman ini khusus untuk administrator ThinkVerse.</p>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 border border-primary/10 premium-shadow">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="font-label-md text-label-md text-on-surface-variant">Alamat Email</label>
                        <input id="email" class="w-full px-6 py-4 rounded-2xl bg-white border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('email') border-red-500 @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="email@contoh.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="font-label-md text-label-md text-on-surface-variant">Kata Sandi</label>
                        </div>
                        <input id="password" class="w-full px-6 py-4 rounded-2xl bg-white border border-primary/10 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none @error('password') border-red-500 @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="w-5 h-5 rounded border-primary/20 text-primary focus:ring-primary/50" name="remember">
                        <label for="remember_me" class="ml-3 font-body-md text-sm text-on-surface-variant">Ingat saya</label>
                    </div>

                    <button type="submit" class="w-full deep-purple-gradient text-on-primary py-4 rounded-2xl font-bold text-lg shadow-[0_15px_30px_rgba(99,14,212,0.2)] purple-glow-hover transition-all active:scale-95 mt-4">
                        Masuk Admin
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
