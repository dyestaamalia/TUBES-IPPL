@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-3 gap-6">

    {{-- ===================== --}}
    {{--    KOLOM POSTINGAN    --}}
    {{-- ===================== --}}
    <div class="col-span-2 space-y-6">

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

        {{-- List Parent Comments --}}
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

                    {{-- Tombol Like + Comment + Bagikan --}}
                    <div class="flex gap-4 text-gray-500 text-sm mt-2">

                        {{-- Like --}}
                        <button type="button" class="love-btn" data-id="{{ $comment->id }}">
                            ❤️ <span class="like-count">{{ $comment->likes->count() }}</span>
                        </button>

                        {{-- Comment --}}
                        <button type="button" class="comment-btn" data-id="{{ $comment->id }}">
                            💬 {{ $comment->replies->count() }}
                        </button>

                        {{-- Share --}}
                        <button onclick="event.stopPropagation(); navigator.clipboard.writeText('{{ url()->current() }}#comment-{{ $comment->id }}')">
                            🔗 Bagikan
                        </button>

                    </div>

                    {{-- Form Reply --}}
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



    {{-- ===================== --}}
    {{--      KOLOM KANAN      --}}
    {{-- ===================== --}}
    <div class="space-y-8">

        {{-- Hewan Peliharaan --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="font-bold text-lg mb-4">Hewan Peliharaan Saya</h2>

            @foreach ($pets as $pet)
                <div class="p-3 border rounded-xl bg-gray-50 mb-2">
                    <strong>{{ $pet->nama }}</strong> —
                    <span class="text-gray-600">{{ $pet->jenis }}</span>
                </div>
            @endforeach

            <a href="/hewan" class="block mt-4 text-center text-cyan-600 border p-2 rounded-xl hover:bg-cyan-50">
                + Tambah Hewan
            </a>
        </div>


        {{-- Tren Diskusi --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h2 class="font-bold text-lg mb-4">Tren Diskusi</h2>

            <p class="hover:text-cyan-600 cursor-pointer">Vaksinasi Anjing</p>
            <p class="hover:text-cyan-600 cursor-pointer">Diet Kucing Gemuk</p>
            <p class="hover:text-cyan-600 cursor-pointer">Perawatan Anjing Senior</p>

            <a href="/" class="block mt-4 text-cyan-600 underline">
                Lihat Semua Forum →
            </a>
        </div>

    </div>

</div>




{{-- =============================== --}}
{{--     SCRIPT LIKE & REPLY         --}}
{{-- =============================== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Klik kotak → buka forum.show
    document.body.addEventListener('click', function(e){
        const box = e.target.closest('.comment-box');
        if(box && !e.target.closest('button')) {
            window.location = box.dataset.href;
        }
    });

    // Like
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.love-btn');
        if (!btn) return;

        e.stopPropagation();

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

    // Comment toggle form reply
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.comment-btn');
        if (!btn) return;

        e.stopPropagation();

        const form = document.getElementById('reply-form-' + btn.dataset.id);
        form.classList.toggle('hidden');
    });

});
</script>

@endsection
