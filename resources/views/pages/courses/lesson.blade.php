@extends('layouts.public')

@section('title', $lesson->title . ' - ' . $course->title)

@section('content')
<div class="bg-surface min-h-screen pb-20">
    <!-- Top Navigation Bar -->
    <div class="bg-white border-b border-primary/10 sticky top-0 z-40">
        <div class="max-w-container-max mx-auto px-4 md:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('courses.show', $course) }}" class="w-10 h-10 rounded-full bg-surface flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div>
                    <p class="text-xs font-bold text-primary uppercase tracking-wider">{{ $course->title }}</p>
                    <h1 class="font-bold text-on-surface">{{ $lesson->title }}</h1>
                </div>
            </div>
            
            <!-- Mobile Menu Toggle for Sidebar -->
            <button class="lg:hidden w-10 h-10 rounded-full bg-surface flex items-center justify-center text-on-surface" onclick="document.getElementById('course-sidebar').classList.toggle('hidden')">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <div class="max-w-container-max mx-auto px-4 md:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar: Course Navigation -->
        <div id="course-sidebar" class="hidden lg:block lg:col-span-1 space-y-4">
            <div class="bg-white rounded-3xl border border-primary/10 overflow-hidden sticky top-28">
                <div class="p-6 border-b border-primary/5 bg-surface/50">
                    <h3 class="font-bold text-on-surface">Daftar Materi</h3>
                </div>
                <div class="max-h-[calc(100vh-200px)] overflow-y-auto">
                    @foreach($course->lessons->whereNull('parent_id') as $index => $chapter)
                        <div class="border-b border-primary/5 last:border-0">
                            <a href="{{ route('courses.lesson', [$course, $chapter]) }}" class="px-6 py-3 flex items-center justify-between gap-3 transition-colors {{ $lesson->id === $chapter->id ? 'bg-primary/10 text-primary border-l-4 border-primary' : 'bg-surface/30 text-on-surface-variant hover:bg-surface hover:text-on-surface' }}">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-sm">Bab {{ $index + 1 }}: {{ $chapter->title }}</h4>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if(($chapter->active_assignments_count ?? 0) > 0)
                                        <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Tugas</span>
                                    @endif
                                    <span class="material-symbols-outlined text-[18px] {{ $lesson->id === $chapter->id ? 'text-primary' : 'text-primary/40' }}">chevron_right</span>
                                </div>
                            </a>
                            @if($chapter->children->count() > 0)
                                <div class="divide-y divide-primary/5">
                                    @foreach($chapter->children as $subLesson)
                                        <a href="{{ route('courses.lesson', [$course, $subLesson]) }}" class="px-6 py-3 flex items-center gap-3 transition-colors {{ $lesson->id === $subLesson->id ? 'bg-primary/5 border-l-4 border-primary text-primary' : 'hover:bg-surface text-on-surface-variant hover:text-on-surface' }}">
                                            <span class="material-symbols-outlined text-[18px] {{ $lesson->id === $subLesson->id ? 'text-primary' : 'text-primary/40' }}">play_circle</span>
                                            <span class="text-sm font-medium flex-1 min-w-0">{{ $subLesson->title }}</span>
                                            @if(($subLesson->active_assignments_count ?? 0) > 0)
                                                <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-1 rounded-full flex-shrink-0">Tugas</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-3 space-y-12">
            
            <!-- Lesson Content -->
            <div class="bg-white rounded-3xl p-6 md:p-12 shadow-sm border border-primary/5">
                <h1 class="font-display-md text-3xl md:text-4xl font-bold text-on-surface mb-8">{{ $lesson->title }}</h1>
                
                @if($lesson->contentBlocks->isEmpty())
                    <div class="text-center py-12 text-on-surface-variant bg-surface rounded-2xl border-2 border-dashed border-primary/20">
                        <span class="material-symbols-outlined text-5xl mb-4 opacity-50">note_stack</span>
                        <p class="font-medium">Konten materi sedang dipersiapkan.</p>
                    </div>
                @else
                    <x-content-renderer :blocks="$lesson->contentBlocks" />
                @endif
            </div>

            <!-- Assignments Section -->
            @if($assignments->isNotEmpty())
                <div class="bg-white rounded-3xl p-6 md:p-10 shadow-sm border border-primary/5">
                    <h2 class="font-display-sm text-2xl font-bold text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-purple-500">assignment</span>
                        Tugas & Evaluasi
                    </h2>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
                            <span class="material-symbols-outlined">error</span>
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="space-y-6">
                        @foreach($assignments as $assignment)
                            <div class="border border-primary/10 rounded-2xl p-6 bg-surface/30">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                                    <div>
                                        <h3 class="font-bold text-lg text-on-surface">{{ $assignment->title }}</h3>
                                        @if($assignment->due_at)
                                            <p class="text-sm font-medium {{ $assignment->due_at->isPast() ? 'text-red-500' : 'text-on-surface-variant' }} mt-1">
                                                Tenggat: {{ $assignment->due_at->format('d M Y, H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                    @auth
                                        @php
                                            $submission = $assignment->submissions()->where('user_id', auth()->id())->first();
                                        @endphp
                                        @if($submission)
                                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-bold flex items-center gap-2 whitespace-nowrap">
                                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                Tugas Dikumpulkan
                                            </span>
                                        @endif
                                    @endauth
                                </div>
                                
                                <div class="prose prose-sm max-w-none text-on-surface-variant mb-6">
                                    {!! $assignment->instruction !!}
                                </div>

                                @auth
                                    @if(!$submission)
                                        @if($assignment->due_at && $assignment->due_at->isPast())
                                            <div class="p-4 bg-red-50 text-red-700 rounded-xl text-sm font-bold border border-red-200">
                                                Waktu pengumpulan tugas telah habis.
                                            </div>
                                        @else
                                            <form action="{{ route('submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-primary/10">
                                                @csrf
                                                <label class="block text-sm font-bold text-on-surface mb-2">Upload Tugas (PDF, Max 10MB)</label>
                                                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                                                    <input type="file" name="submission_file" accept=".pdf" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required>
                                                    <button type="submit" class="px-6 py-2 bg-primary text-white font-bold rounded-full hover:bg-primary/90 whitespace-nowrap shadow-md shadow-primary/20 transition-all">Submit Tugas</button>
                                                </div>
                                                @error('submission_file')
                                                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                                                @enderror
                                            </form>
                                        @endif
                                    @else
                                        <div class="bg-white p-4 rounded-xl border border-green-200 flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-green-500">description</span>
                                                <div>
                                                    <p class="text-sm font-bold text-on-surface">File Anda telah terkirim</p>
                                                    <p class="text-xs text-on-surface-variant">Pada {{ $submission->submitted_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-primary font-bold text-sm hover:underline">Lihat File</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl text-sm font-bold border border-yellow-200">
                                        Silakan <a href="{{ route('login') }}" class="underline text-yellow-900">Login</a> untuk mengumpulkan tugas.
                                    </div>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comments Section -->
            <div class="bg-white rounded-3xl p-6 md:p-10 shadow-sm border border-primary/5" id="comments">
                <h2 class="font-display-sm text-2xl font-bold text-on-surface mb-8 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">forum</span>
                    Diskusi ({{ $comments->count() }})
                </h2>

                @auth
                    <form action="{{ route('comments.store', $course) }}" method="POST" class="mb-10">
                        @csrf
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold flex-shrink-0">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="flex-grow">
                                <textarea name="body" rows="3" placeholder="Tulis pertanyaan atau diskusi..." class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm mb-3" required></textarea>
                                @error('body')
                                    @if(!old('parent_id'))
                                        <p class="text-red-500 text-xs mb-3 font-medium">{{ $message }}</p>
                                    @endif
                                @enderror
                                <div class="flex justify-end">
                                    <button type="submit" class="px-6 py-2 bg-primary text-white font-bold rounded-full hover:bg-primary/90 text-sm shadow-md shadow-primary/20">Kirim Diskusi</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="p-6 bg-surface rounded-2xl text-center mb-10 border border-primary/5">
                        <p class="text-on-surface-variant font-medium mb-3">Ingin bergabung dalam diskusi?</p>
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-primary text-white font-bold rounded-full hover:bg-primary/90 text-sm shadow-md shadow-primary/20">Login Sekarang</a>
                    </div>
                @endauth

                <div class="space-y-8">
                    @forelse($comments as $comment)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-surface border border-primary/10 flex items-center justify-center text-on-surface-variant font-bold flex-shrink-0">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-grow">
                                <div class="bg-surface rounded-2xl rounded-tl-none p-4 mb-2">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-bold text-on-surface text-sm">{{ $comment->user->name }}</h4>
                                        <span class="text-xs text-on-surface-variant">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-on-surface-variant">{{ $comment->body }}</p>
                                </div>
                                
                                <!-- Placeholder for Reply Button -->
                                @auth
                                <button class="text-xs font-bold text-primary hover:underline ml-2" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')">Balas</button>
                                
                                <!-- Reply Form -->
                                <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $course) }}" method="POST" class="hidden mt-3 mb-4">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <div class="flex gap-3">
                                        <div class="flex-grow">
                                            <textarea name="body" rows="2" placeholder="Tulis balasan..." class="w-full px-4 py-2 bg-white border border-primary/10 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm" required></textarea>
                                            @if($errors->has('body') && old('parent_id') == $comment->id)
                                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $errors->first('body') }}</p>
                                            @endif
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-secondary text-white font-bold rounded-xl hover:bg-secondary/90 text-sm h-fit">Kirim</button>
                                    </div>
                                </form>
                                @endauth

                                <!-- Replies -->
                                @if($comment->replies->count() > 0)
                                    <div class="mt-4 space-y-4">
                                        @foreach($comment->replies as $reply)
                                            <div class="flex gap-3">
                                                <div class="w-8 h-8 rounded-full bg-white border border-primary/10 flex items-center justify-center text-on-surface-variant font-bold text-xs flex-shrink-0">
                                                    {{ substr($reply->user->name, 0, 1) }}
                                                </div>
                                                <div class="flex-grow">
                                                    <div class="bg-white border border-primary/5 rounded-2xl rounded-tl-none p-3">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <h4 class="font-bold text-on-surface text-xs">{{ $reply->user->name }}</h4>
                                                            <span class="text-[10px] text-on-surface-variant">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-sm text-on-surface-variant">{{ $reply->body }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl mb-2 opacity-50">chat_bubble</span>
                            <p>Jadilah yang pertama memulai diskusi!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
