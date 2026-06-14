@extends('layouts.admin')

@section('title', 'Reviu Tugas: ' . $assignment->title)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-2 text-sm font-medium text-on-surface-variant">
            <a href="{{ route('admin.courses.index') }}" class="hover:text-primary transition-colors">Kursus</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a href="{{ route('admin.courses.assignments.index', $course) }}" class="hover:text-primary transition-colors">{{ $course->title }}</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface">Reviu Tugas</span>
        </div>
        <h1 class="font-display-lg text-3xl font-extrabold text-on-surface">Reviu: {{ $assignment->title }}</h1>
    </div>
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
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Siswa</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Waktu Pengumpulan</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Status</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant">Nilai</th>
                    <th class="px-6 py-4 font-bold text-on-surface-variant text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary/5">
                @forelse($submissions as $submission)
                @php($studentName = $submission->student_display_name)
                <tr class="hover:bg-surface/30 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-xs">
                                {{ substr($studentName, 0, 1) }}
                            </div>
                            <div class="font-bold text-on-surface">{{ $studentName }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-on-surface-variant">
                            {{ $submission->submitted_at->format('d M Y, H:i') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($submission->status === 'graded')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                Sudah Dinilai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-bold border border-orange-200">
                                Menunggu Reviu
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-on-surface">{{ $submission->score ?? '-' }} / 100</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="openReviewModal({{ $submission->id }}, @js(Storage::url($submission->file_path)), @js($studentName), @js($submission->score), @js($submission->feedback ?? ''))" class="px-4 py-2 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl font-bold text-sm transition-colors">
                            Beri Nilai
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-5xl mb-4 opacity-50">inbox</span>
                        <p class="font-medium">Belum ada tugas yang dikumpulkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-primary/5 flex items-center justify-between bg-surface/50">
            <h3 class="font-bold text-lg text-on-surface">Reviu Tugas: <span id="studentName"></span></h3>
            <button onclick="closeReviewModal()" class="text-on-surface-variant hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <div class="mb-6 p-4 bg-surface rounded-2xl border border-primary/5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">picture_as_pdf</span>
                    <div>
                        <p class="text-sm font-bold text-on-surface">File Tugas PDF</p>
                    </div>
                </div>
                <a id="fileLink" href="#" target="_blank" class="px-4 py-2 bg-white border border-primary/10 rounded-xl text-primary font-bold text-sm hover:border-primary transition-colors">Lihat Dokumen</a>
            </div>

            <form id="reviewForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Nilai (0-100)</label>
                        <input type="number" id="inputGrade" name="score" min="0" max="100" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Umpan Balik / Catatan</label>
                        <textarea id="inputFeedback" name="feedback" rows="4" class="w-full px-4 py-3 bg-surface border-none rounded-2xl focus:ring-2 focus:ring-primary/20"></textarea>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" onclick="closeReviewModal()" class="px-6 py-2 text-on-surface-variant font-bold">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-primary text-white font-bold rounded-xl shadow-md">Simpan Nilai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openReviewModal(id, fileUrl, studentName, grade, feedback) {
        document.getElementById('studentName').innerText = studentName;
        document.getElementById('fileLink').href = fileUrl;
        document.getElementById('inputGrade').value = grade;
        document.getElementById('inputFeedback').value = feedback;
        
        // Setup form action route
        const form = document.getElementById('reviewForm');
        form.action = `/admin/submissions/${id}`;
        
        document.getElementById('reviewModal').classList.remove('hidden');
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').classList.add('hidden');
    }
</script>
@endsection
