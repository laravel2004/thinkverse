@props(['blocks'])

<div class="space-y-8">
    @foreach($blocks as $block)
        @if($block->type === 'text')
            <div class="prose prose-lg max-w-none text-on-surface">
                {!! $block->payload['content'] ?? '' !!}
            </div>
        @elseif($block->type === 'code')
            <div class="bg-[#1e1e1e] rounded-2xl overflow-hidden shadow-lg border border-primary/10">
                <div class="flex items-center justify-between px-4 py-2 bg-[#2d2d2d] border-b border-gray-700">
                    <span class="text-xs font-mono text-gray-400 font-bold tracking-wider uppercase">{{ $block->payload['language'] ?? 'code' }}</span>
                    <button class="text-xs text-gray-400 hover:text-white transition-colors" onclick="navigator.clipboard.writeText(`{{ addslashes($block->payload['code'] ?? '') }}`)">Copy</button>
                </div>
                <div class="p-4 overflow-x-auto">
                    <pre><code class="text-sm font-mono text-[#d4d4d4] whitespace-pre">{{ $block->payload['code'] ?? '' }}</code></pre>
                </div>
            </div>
        @elseif($block->type === 'notice')
            @php
                $type = $block->payload['type'] ?? 'info';
                $colors = [
                    'info' => 'bg-blue-50 text-blue-800 border-blue-200 icon-info',
                    'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200 icon-warning',
                    'success' => 'bg-green-50 text-green-800 border-green-200 icon-check_circle',
                ];
                $style = $colors[$type] ?? $colors['info'];
                $icon = explode('icon-', $style)[1];
                $style = explode(' icon-', $style)[0];
            @endphp
            <div class="flex gap-4 p-5 rounded-2xl border {{ $style }}">
                <span class="material-symbols-outlined flex-shrink-0 mt-0.5">{{ $icon }}</span>
                <div class="font-medium">
                    {!! nl2br(e($block->payload['message'] ?? '')) !!}
                </div>
            </div>
        @elseif($block->type === 'link')
            <div class="my-4">
                <a href="{{ $block->payload['url'] ?? '#' }}" target="_blank" class="text-primary hover:underline font-medium inline-flex items-center gap-1">
                    {{ $block->payload['text'] ?? ($block->payload['url'] ?? '') }}
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                </a>
            </div>
        @elseif($block->type === 'button')
            <div class="my-6">
                @php
                    $btnStyle = ($block->payload['style'] ?? 'primary') === 'outline' 
                        ? 'bg-transparent border-2 border-primary text-primary hover:bg-primary/5'
                        : 'bg-primary border-2 border-primary text-white hover:bg-primary/90 shadow-md shadow-primary/20';
                @endphp
                <a href="{{ $block->payload['url'] ?? '#' }}" target="_blank" class="inline-block px-8 py-3 rounded-xl font-bold transition-all {{ $btnStyle }}">
                    {{ $block->payload['text'] ?? 'Button' }}
                </a>
            </div>
        @elseif($block->type === 'youtube')
            @php
                $url = $block->payload['url'] ?? '';
                // Extract video ID
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $match);
                $videoId = $match[1] ?? null;
            @endphp
            @if($videoId)
            <div class="my-8 aspect-video rounded-3xl overflow-hidden shadow-lg border border-primary/10">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            @endif
        @elseif($block->type === 'image')
            @if(isset($block->payload['file_path']))
                <figure class="my-8">
                    <img src="{{ Storage::url($block->payload['file_path']) }}" alt="{{ $block->payload['caption'] ?? '' }}" class="w-full h-auto rounded-3xl shadow-md border border-primary/5">
                    @if(!empty($block->payload['caption']))
                        <figcaption class="mt-3 text-center text-sm text-on-surface-variant italic">{{ $block->payload['caption'] }}</figcaption>
                    @endif
                </figure>
            @endif
        @elseif($block->type === 'pdf')
            @if(isset($block->payload['file_path']))
                <div class="my-6 p-6 rounded-2xl border border-primary/10 bg-surface flex items-center justify-between gap-4 group hover:border-primary transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined">picture_as_pdf</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-on-surface group-hover:text-primary transition-colors">{{ $block->payload['title'] ?? 'Dokumen PDF' }}</h4>
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider mt-1">PDF File</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($block->payload['file_path']) }}" target="_blank" class="px-4 py-2 bg-white border border-primary/10 rounded-xl text-primary font-bold text-sm hover:border-primary transition-colors whitespace-nowrap shadow-sm">
                        Buka / Unduh
                    </a>
                </div>
            @endif
        @endif
    @endforeach
</div>
