@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-3 gap-6">

    {{-- ===================== --}}
    {{--    KOLOM POSTINGAN    --}}
    {{-- ===================== --}}
    <div class="col-span-2 space-y-6">

        {{-- Form Tambah Post Baru (Redesign) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <img src="https://i.pravatar.cc/50?u={{ auth()->id() }}" 
                         class="w-12 h-12 rounded-full border-2 border-cyan-200">
                    <div>
                        <h3 class="font-bold text-gray-900">Tambahkan diskusi</h3>
                        <p class="text-sm text-gray-500">Bagikan pengalamanmu dengan komunitas</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('comments.store') }}" method="POST" class="p-5">
                @csrf
                
                {{-- Input Judul --}}
                <input type="text" 
                       name="title" 
                       class="w-full border-0 border-b border-gray-200 focus:border-cyan-500 focus:ring-0 px-0 py-3 text-lg font-semibold placeholder-gray-400"
                       placeholder="Judul diskusi (opsional)..."
                       maxlength="100">
                
                {{-- Textarea Content --}}
                <textarea name="content" 
                          class="w-full border-0 focus:ring-0 px-0 py-4 text-gray-700 placeholder-gray-400 resize-none"
                          rows="4" 
                          placeholder="Apa yang ingin kamu diskusikan?"
                          required></textarea>
                
                {{-- Input Hashtags --}}
                <input type="text" 
                       name="hashtags" 
                       class="w-full border-0 border-t border-gray-200 focus:border-cyan-500 focus:ring-0 px-0 py-3 text-sm placeholder-gray-400"
                       placeholder="Tambahkan hashtag: #VaksinasiAnjing #TipsKesehatan">
                
                {{-- Action Buttons --}}
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <div class="flex gap-2">
                        <button type="button" class="p-2 hover:bg-gray-100 rounded-lg transition" title="Tambah gambar">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                    <button type="submit" 
                            class="bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all">
                        Posting
                    </button>
                </div>
            </form>
        </div>

        {{-- List Posts --}}
        @forelse($comments as $comment)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all overflow-hidden"
             id="comment-{{ $comment->id }}">

            {{-- Post Header --}}
            <div class="p-5 border-b border-gray-50">
                <div class="flex items-start justify-between">
                    <div class="flex gap-3">
                        <img src="https://i.pravatar.cc/50?u={{ $comment->user->id ?? 'deleted' }}" 
                             class="w-12 h-12 rounded-full border-2 border-gray-100">
                        <div>
                            <p class="font-bold text-gray-900">{{ $comment->user->name ?? 'Deleted User' }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    {{-- Delete Button (Hanya Pemilik) --}}
                    @if(auth()->check() && auth()->id() === $comment->user_id)
                    <button type="button" 
                            class="delete-post-btn text-gray-400 hover:text-red-500 transition p-2"
                            data-id="{{ $comment->id }}"
                            title="Hapus post">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>

            {{-- Post Content --}}
            <div class="p-5 cursor-pointer hover:bg-gray-50 transition"
                 onclick="window.location='{{ route('forum.show', $comment->id) }}'">
                
                {{-- Judul (Bold) --}}
                @if($comment->title)
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    {{ $comment->title }}
                </h3>
                @endif
                
                {{-- Isi Post --}}
                <p class="text-gray-700 leading-relaxed mb-3">
                    {{ Str::limit($comment->content, 200) }}
                </p>
                
                {{-- Hashtags --}}
                @if($comment->hashtags)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach(explode(',', $comment->hashtags) as $tag)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-50 text-cyan-600 hover:bg-cyan-100 transition cursor-pointer">
                        {{ trim($tag) }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Post Actions --}}
            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50">
                <div class="flex items-center gap-6 text-gray-600">
                    
                    {{-- Like --}}
                    <button type="button" 
                            class="love-btn flex items-center gap-2 hover:text-red-500 transition font-medium"
                            data-id="{{ $comment->id }}"
                            onclick="event.stopPropagation()">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span class="like-count">{{ $comment->likes->count() }}</span>
                    </button>

                    {{-- Comment --}}
                    <a href="{{ route('forum.show', $comment->id) }}" 
                       class="flex items-center gap-2 hover:text-cyan-500 transition font-medium"
                       onclick="event.stopPropagation()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>{{ $comment->replies->count() }}</span>
                    </a>

                    {{-- Share --}}
                    <button type="button" 
                            class="share-post-btn flex items-center gap-2 hover:text-green-500 transition font-medium ml-auto"
                            data-id="{{ $comment->id }}"
                            data-url="{{ route('forum.show', $comment->id) }}"
                            onclick="event.stopPropagation()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span>Bagikan</span>
                    </button>

                </div>
            </div>

        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada diskusi</h3>
            <p class="text-gray-500">Jadilah yang pertama memulai diskusi!</p>
        </div>
        @endforelse

    </div>



    {{-- ===================== --}}
    {{--      KOLOM KANAN      --}}
    {{-- ===================== --}}
    <div class="space-y-6">

        {{-- Hewan Peliharaan (Interactive) --}}
        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl shadow-sm border border-cyan-100 overflow-hidden">
            <div class="p-5 border-b border-cyan-100 bg-white/50">
                <h2 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <span class="text-2xl">🐾</span>
                    Hewan Peliharaan Saya
                </h2>
            </div>
            
            <div class="p-5 space-y-3">
                @forelse ($pets as $pet)
                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-all border border-gray-100 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($pet->nama, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 group-hover:text-cyan-600 transition">{{ $pet->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $pet->jenis }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6">
                    <p class="text-gray-500 text-sm mb-3">Belum ada hewan peliharaan</p>
                </div>
                @endforelse

                <a href="/hewan" 
                   class="block w-full text-center py-3 px-4 bg-white hover:bg-cyan-50 text-cyan-600 font-semibold rounded-xl border-2 border-dashed border-cyan-300 hover:border-cyan-400 transition-all">
                    + Tambah Hewan
                </a>
            </div>
        </div>


        {{-- Tren Diskusi (Interactive) --}}
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl shadow-sm border border-purple-100 overflow-hidden">
            <div class="p-5 border-b border-purple-100 bg-white/50">
                <h2 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                    <span class="text-2xl">🔥</span>
                    Tren Diskusi
                </h2>
            </div>
            
            <div class="p-5 space-y-3">
                @php
                $trendingTopics = [
                    ['title' => 'Vaksinasi Anjing', 'icon' => '💉', 'count' => '12 Komentar'],
                    ['title' => 'Diet Kucing Gemuk', 'icon' => '🐱', 'count' => '8 Komentar'],
                    ['title' => 'Perawatan Anjing Senior', 'icon' => '🐕', 'count' => '5 Komentar'],
                ];
                @endphp

                @foreach($trendingTopics as $index => $topic)
                <div class="bg-white rounded-xl p-4 hover:shadow-md transition-all cursor-pointer group border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 group-hover:text-purple-600 transition">
                                {{ $topic['title'] }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $topic['count'] }}</p>
                        </div>
                        <span class="text-2xl">{{ $topic['icon'] }}</span>
                    </div>
                </div>
                @endforeach

                <a href="/" 
                   class="block text-center text-purple-600 hover:text-purple-700 font-semibold mt-4 py-2 hover:bg-purple-50 rounded-lg transition">
                    Lihat Semua Forum →
                </a>
            </div>
        </div>

    </div>

</div>




{{-- =============================== --}}
{{--     SCRIPT INTERACTIONS         --}}
{{-- =============================== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    // === LIKE BUTTON ===
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.love-btn');
        if (!btn) return;

        e.stopPropagation();
        const id = btn.dataset.id;
        const count = btn.querySelector('.like-count');

        fetch(`/comments/${id}/like`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }
        })
        .then(res => res.json())
        .then(data => {
            count.textContent = data.likes_count ?? 0;
            btn.classList.add('text-red-500');
            setTimeout(() => btn.classList.remove('text-red-500'), 300);
        })
        .catch(err => console.error(err));
    });

    // === SHARE BUTTON ===
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.share-post-btn');
        if (!btn) return;

        e.stopPropagation();
        const url = window.location.origin + btn.dataset.url;
        
        navigator.clipboard.writeText(url).then(() => {
            const originalText = btn.querySelector('span').textContent;
            btn.querySelector('span').textContent = 'Link disalin!';
            btn.classList.add('text-green-500');
            
            setTimeout(() => {
                btn.querySelector('span').textContent = originalText;
                btn.classList.remove('text-green-500');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy:', err);
            alert('Gagal menyalin link');
        });
    });

    // === DELETE POST ===
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-post-btn');
        if (!btn) return;

        e.stopPropagation();
        
        if (!confirm('Yakin ingin menghapus diskusi ini beserta semua komentarnya?')) return;
        
        const id = btn.dataset.id;
        
        fetch(`/comments/${id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const post = document.getElementById(`comment-${id}`);
                post.style.opacity = '0';
                post.style.transform = 'scale(0.95)';
                setTimeout(() => post.remove(), 300);
                
                // Show success notification
                const notif = document.createElement('div');
                notif.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50';
                notif.textContent = '✓ Diskusi berhasil dihapus';
                document.body.appendChild(notif);
                setTimeout(() => notif.remove(), 3000);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menghapus diskusi');
        });
    });

});
</script>

<script>
// Auto refresh CSRF token setiap 10 menit
setInterval(function() {
    fetch('/refresh-csrf', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
        document.querySelectorAll('input[name="_token"]').forEach(input => {
            input.value = data.token;
        });
    });
}, 600000); // 10 menit
</script>
@endsection