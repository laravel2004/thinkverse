@extends('layouts.admin')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface tracking-tight mb-2">Daftar Pengguna</h1>
        <p class="text-on-surface-variant font-body-md">Kelola pengguna yang terdaftar di ThinkVerse. Total: {{ $users->total() }} pengguna.</p>
    </div>
</div>

<div class="bg-white rounded-[2rem] border border-primary/5 premium-shadow overflow-hidden">
    <!-- Filter Bar -->
    <div class="p-6 border-b border-primary/5 bg-surface-container-lowest/50">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label for="search" class="block text-sm font-bold text-on-surface mb-2">Cari Pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center justify-center w-11 pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3 bg-white border border-primary/10 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md" placeholder="Cari nama atau email...">
                </div>
            </div>
            
            <div class="w-full md:w-1/4">
                <label for="role" class="block text-sm font-bold text-on-surface mb-2">Filter Role</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center justify-center w-11 pointer-events-none text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                    </div>
                    <select name="role" id="role" class="w-full pl-11 pr-10 py-3 bg-white border border-primary/10 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface font-body-md appearance-none">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-sm shadow-primary/20">
                    Terapkan
                </button>
                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-surface text-on-surface-variant font-bold rounded-xl hover:bg-surface-dim transition-colors text-center border border-primary/10">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-primary/5 bg-surface/30">
                    <th class="py-4 px-6 font-bold text-sm text-on-surface-variant uppercase tracking-wider">No</th>
                    <th class="py-4 px-6 font-bold text-sm text-on-surface-variant uppercase tracking-wider">Nama</th>
                    <th class="py-4 px-6 font-bold text-sm text-on-surface-variant uppercase tracking-wider">Email</th>
                    <th class="py-4 px-6 font-bold text-sm text-on-surface-variant uppercase tracking-wider">Role</th>
                    <th class="py-4 px-6 font-bold text-sm text-on-surface-variant uppercase tracking-wider">Status</th>
                    <th class="py-4 px-6 font-bold text-sm text-on-surface-variant uppercase tracking-wider">Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr class="border-b border-primary/5 hover:bg-surface/50 transition-colors group">
                        <td class="py-4 px-6 text-on-surface-variant">{{ $users->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-bold text-on-surface flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            {{ $user->name }}
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">shield_person</span>
                                    Admin
                                </span>
                            @else
                                <span class="px-3 py-1 bg-surface-dim text-on-surface-variant rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">person</span>
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($user->email_verified_at)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                    Verified
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">pending</span>
                                    Unverified
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center text-on-surface-variant">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-6xl text-primary/20 mb-4">group_off</span>
                                <p class="text-lg font-medium mb-1">Belum ada data pengguna</p>
                                <p class="text-sm opacity-80 mb-6">Pengguna tidak ditemukan atau belum ada yang mendaftar.</p>
                                @if(request()->hasAny(['search', 'role']))
                                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-surface text-on-surface font-bold rounded-xl hover:bg-surface-dim transition-colors">
                                        Reset Pencarian
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="p-6 border-t border-primary/5 bg-surface-container-lowest/50">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
