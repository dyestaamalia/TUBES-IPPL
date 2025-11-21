@php
    $indent = $level * 2;
@endphp

<div class="flex flex-col gap-2 p-3 rounded-xl border border-gray-200 bg-white"
     id="comment-{{ $comment->id }}"
     style="margin-left: {{ $indent }}rem;">

    <div class="flex gap-4 items-start">
        <img src="https://i.pravatar.cc/45" class="w-11 h-11 rounded-full">
        <div class="flex-1">
            <p class="font-semibold">{{ optional($comment->user)->name ?? 'Deleted User' }}</p>
            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
            <p class="mt-2 text-gray-700">{{ $comment->content }}</p>

            <div class="flex gap-4 text-gray-500 text-sm mt-2">
                {{-- Tombol Like --}}
                <button type="button" class="love-btn" data-id="{{ $comment->id }}">
                    ❤️ <span class="like-count">{{ $comment->likes->count() }}</span>
                </button>

                {{-- Tombol Reply --}}
                <button type="button" class="reply-btn" data-id="{{ $comment->id }}">
                    💬 Reply
                </button>

                {{-- Tombol Bagikan --}}
                <button onclick="event.stopPropagation(); navigator.clipboard.writeText('{{ url()->current() }}#comment-{{ $comment->id }}')">
                    🔗 Bagikan
                </button>
            </div>
        </div>
    </div>

    {{-- Form Balasan (hidden awal) --}}
    <div class="mt-2 hidden reply-form" id="reply-form-{{ $comment->id }}">
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="flex gap-3 mt-2">
                <img src="https://i.pravatar.cc/50" class="w-10 h-10 rounded-full">
                <textarea name="content" class="flex-1 border rounded-xl p-2" rows="2" placeholder="Tulis balasan Anda..."></textarea>
            </div>
            <div class="text-right mt-2">
                <button type="submit" class="bg-[#13CAD6] text-white px-4 py-2 rounded-xl text-sm">Kirim</button>
            </div>
        </form>
    </div>

    {{-- Render balasan rekursif --}}
    @if($comment->replies)
        <div class="mt-3 border-l border-gray-200 pl-4 space-y-3">
            @foreach($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
