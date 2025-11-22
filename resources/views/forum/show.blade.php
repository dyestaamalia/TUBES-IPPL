{{-- resources/views/forum/show.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
.love-btn, .reply-action-btn {
    transition: all 0.2s ease;
}
.love-btn:hover, .reply-action-btn:hover {
    transform: scale(1.05);
}
.love-btn:active, .reply-action-btn:active {
    transform: scale(0.95);
}
.gradient-border {
    position: relative;
}
.gradient-border::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(to right, #3b82f6, #8b5cf6, #ec4899);
    border-radius: 1rem;
    opacity: 0.3;
    filter: blur(8px);
    z-index: -1;
    transition: opacity 0.3s;
}
.gradient-border:hover::before {
    opacity: 0.5;
}
</style>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    
    {{-- Header --}}
    <div class="sticky top-0 bg-white/90 backdrop-blur-xl border-b border-gray-200 z-10 shadow-sm">
        <div class="max-w-3xl mx-auto px-4 py-4">
            <div class="flex items-center gap-4">
                <button onclick="window.history.back()"
                        class="p-2 hover:bg-gray-100 rounded-full transition-all duration-200 group active:scale-95">
                    <svg class="w-5 h-5 text-gray-600 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Forum Diskusi</h1>
                    <p class="text-sm text-gray-500">Komentar dan balasannya</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="max-w-3xl mx-auto px-4 pt-6">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <span class="font-medium">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 font-bold">✕</button>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <div class="max-w-3xl mx-auto px-4 py-6 space-y-6">
        
        {{-- Main Post - Highlighted --}}
        <div class="gradient-border">
            <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300">
                
                {{-- Post Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="https://i.pravatar.cc/150?u={{ $comment->user->id }}" 
                                 alt="{{ $comment->user->name }}"
                                 class="w-12 h-12 rounded-full ring-2 ring-blue-400 ring-offset-2">
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-gray-900">{{ $comment->user->name }}</h3>
                                <span class="text-xs bg-gradient-to-r from-blue-500 to-purple-500 text-white px-2 py-0.5 rounded-full font-semibold">
                                    Pembuat
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    @if(auth()->check() && auth()->id() === $comment->user_id)
                        <button type="button" 
                                class="delete-btn p-2 hover:bg-red-50 rounded-lg transition-colors text-gray-400 hover:text-red-500"
                                data-id="{{ $comment->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    @endif
                </div>

                {{-- Post Title --}}
                @if($comment->title)
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $comment->title }}</h2>
                @endif

                {{-- Post Content --}}
                <p class="text-gray-700 text-lg leading-relaxed mb-4">{{ $comment->content }}</p>

                {{-- Hashtags --}}
                @if($comment->hashtags)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php
                            $hashtagArray = array_filter(array_map('trim', explode(',', $comment->hashtags)));
                        @endphp
                        @foreach($hashtagArray as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-purple-100 text-blue-700 hover:from-blue-200 hover:to-purple-200 transition-colors cursor-pointer">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    
                    {{-- Like Button --}}
                    <button type="button" 
                            class="love-btn flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-200 bg-gray-50 text-gray-600 hover:bg-red-50 hover:text-red-500"
                            data-id="{{ $comment->id }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="like-count font-semibold">{{ $comment->likes->count() }}</span>
                    </button>

                    {{-- Reply Button --}}
                    <button type="button" 
                            class="reply-btn flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 text-gray-600 hover:bg-blue-50 hover:text-blue-500 transition-all duration-200"
                            data-id="{{ $comment->id }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="font-semibold">{{ $comment->replies->count() }}</span>
                    </button>

                    {{-- Share Button --}}
                    <button type="button" 
                            class="share-btn flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 text-gray-600 hover:bg-green-50 hover:text-green-500 transition-all duration-200 ml-auto"
                            data-url="{{ route('forum.show', $comment->id) }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span class="font-semibold">Bagikan</span>
                    </button>
                </div>

                {{-- Reply Form --}}
                <div class="mt-4 pt-4 border-t border-gray-100 hidden" id="reply-form-{{ $comment->id }}">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        
                        <div class="flex gap-3">
                            <img src="https://i.pravatar.cc/150?u={{ auth()->id() }}" 
                                 alt="You"
                                 class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <textarea name="content" 
                                          rows="3"
                                          class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-all"
                                          placeholder="Tulis balasan Anda..."
                                          required></textarea>
                                <div class="flex gap-2 mt-2 justify-end">
                                    <button type="button"
                                            class="cancel-reply-btn px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                                            data-id="{{ $comment->id }}">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg hover:shadow-lg transition-all duration-200 hover:scale-105 active:scale-95 flex items-center gap-2 font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Kirim
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        @if($comment->replies->count() > 0)
            <div class="flex items-center gap-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <span class="text-sm text-gray-500 font-semibold px-4 py-1.5 bg-gradient-to-r from-blue-50 to-purple-50 rounded-full border border-gray-200">
                    {{ $comment->replies->count() }} Balasan
                </span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>
        @endif

        {{-- Replies --}}
        <div class="space-y-4">
            @forelse($comment->replies as $reply)
                <div id="comment-{{ $reply->id }}" 
                     class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all duration-200 ml-6 relative before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1 before:bg-gradient-to-b before:from-blue-400 before:to-purple-400 before:rounded-l-xl">
                    <div class="flex items-start gap-3">
                        <img src="https://i.pravatar.cc/150?u={{ $reply->user->id }}"
                             alt="{{ $reply->user->name }}"
                             class="w-10 h-10 rounded-full ring-2 ring-gray-100">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $reply->user->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                                @if(auth()->check() && auth()->id() === $reply->user_id)
                                    <button type="button" 
                                            class="delete-btn text-gray-400 hover:text-red-500 transition-colors"
                                            data-id="{{ $reply->id }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            <p class="text-gray-700 leading-relaxed mb-3">{{ $reply->content }}</p>
                            
                            {{-- Reply Actions --}}
                            <div class="flex items-center gap-4">
                                <button type="button"
                                        class="reply-action-btn love-btn flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg transition-all duration-200 text-gray-500 hover:bg-red-50 hover:text-red-500"
                                        data-id="{{ $reply->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span class="like-count font-medium">{{ $reply->likes->count() }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada balasan</h3>
                    <p class="text-gray-500 mb-6">Klik tombol Reply di atas untuk membalas!</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Floating Action Button --}}
    <button type="button"
            class="reply-btn fixed bottom-8 right-8 w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full shadow-2xl hover:scale-110 active:scale-95 transition-all duration-200 flex items-center justify-center z-20"
            data-id="{{ $comment->id }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
    </button>
</div>

<script src="{{ asset('js/comment-interaction.js') }}"></script>

@endsection