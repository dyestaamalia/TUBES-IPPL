@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

     {{-- Form Tambah Parent Comment --}}
    <div class="bg-white p-4 rounded-xl shadow">
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div class="flex gap-3">
                <img src="https://i.pravatar.cc/50" class="w-10 h-10 rounded-full">
                <textarea name="content" class="flex-1 border rounded-xl p-2" rows="2" placeholder="Tulis komentar baru..."></textarea>
            </div>
            <div class="text-right mt-2">
                <button type="submit" class="bg-[#13CAD6] text-white px-4 py-2 rounded-xl text-sm">Kirim</button>
            </div>
        </form>
    </div>
    @foreach($comments as $comment)
    <div class="bg-white p-4 rounded-xl shadow comment-box cursor-pointer" 
         data-href="{{ route('forum.show', $comment->id) }}" 
         id="comment-{{ $comment->id }}">

        <div class="flex gap-3">
            <img src="https://i.pravatar.cc/50" class="w-12 h-12 rounded-full">
            <div class="flex-1">
                <p class="font-semibold">{{ $comment->user->name ?? 'Deleted User' }}</p>
                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                <p class="mt-1 text-gray-700">{{ $comment->content }}</p>

                <div class="flex gap-4 text-gray-500 text-sm mt-2">
                    {{-- Tombol Like --}}
                    <button type="button" class="love-btn" data-id="{{ $comment->id }}">
                        ❤️ <span class="like-count">{{ $comment->likes->count() }}</span>
                    </button>

                    {{-- Tombol Comment --}}
                    <button type="button" class="comment-btn" data-id="{{ $comment->id }}">
                        💬 {{ $comment->replies->count() }}
                    </button>

                    {{-- Tombol Bagikan --}}
                    <button onclick="event.stopPropagation(); navigator.clipboard.writeText('{{ url()->current() }}#comment-{{ $comment->id }}')">
                        🔗 Bagikan
                    </button>
                </div>

                {{-- Form Tambah Balasan (hidden awal) --}}
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

            </div>
        </div>
    </div>
    @endforeach

</div>

{{-- AJAX Like, Toggle Reply, dan Navigasi Comment Box --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Klik di kotak comment → buka forum.show
    document.body.addEventListener('click', function(e){
        const box = e.target.closest('.comment-box');
        if(box && !e.target.closest('button')) {
            window.location = box.dataset.href;
        }
    });

    // Tombol Like
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.love-btn');
        if (!btn) return;
        e.stopPropagation(); // jangan trigger click parent
        const commentId = btn.dataset.id;
        const likeCountEl = btn.querySelector('.like-count');
        const token = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/comments/${commentId}/like`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }
        })
        .then(res => res.json())
        .then(data => likeCountEl.textContent = data.likes_count ?? 0)
        .catch(err => console.error(err));
    });

    // Tombol Comment → toggle reply form
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.comment-btn');
        if (!btn) return;
        e.stopPropagation(); // jangan trigger click parent
        const form = document.getElementById('reply-form-' + btn.dataset.id);
        form.classList.toggle('hidden');
    });

});
</script>
@endsection
