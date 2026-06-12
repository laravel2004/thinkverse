<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\ContentBlock;
use Illuminate\Http\Request;

class ContentBlockController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'type' => 'required|string',
            'payload' => 'required|array',
            'payload.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240', // Max 10MB
        ]);

        $payload = $request->input('payload', []);

        // Handle file upload if exists
        if ($request->hasFile('payload.file')) {
            $path = $request->file('payload.file')->store('content_blocks', 'public');
            $payload['file_path'] = $path;
            unset($payload['file']);
        }

        $data = [
            'type' => $request->input('type'),
            'payload' => $payload,
            'lesson_id' => $lesson->id,
            'sort_order' => ContentBlock::where('lesson_id', $lesson->id)->max('sort_order') + 1
        ];

        ContentBlock::create($data);

        return back()->with('success', 'Blok konten berhasil ditambahkan!');
    }

    public function update(Request $request, ContentBlock $block)
    {
        $request->validate([
            'payload' => 'required|array',
            'payload.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240',
        ]);

        $payload = $request->input('payload', []);

        // Handle file upload if exists
        if ($request->hasFile('payload.file')) {
            $path = $request->file('payload.file')->store('content_blocks', 'public');
            $payload['file_path'] = $path;
            unset($payload['file']);
        } else {
            // Keep the old file path if not uploading a new one
            if (isset($block->payload['file_path'])) {
                $payload['file_path'] = $block->payload['file_path'];
            }
        }

        $block->update(['payload' => $payload]);

        return back()->with('success', 'Blok konten berhasil diperbarui!');
    }

    public function destroy(ContentBlock $block)
    {
        $block->delete();
        return back()->with('success', 'Blok konten dihapus!');
    }
}
