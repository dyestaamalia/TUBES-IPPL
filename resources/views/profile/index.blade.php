@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </span>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">✕</button>
        </div>
    @endif

    {{-- Header Card --}}
    <div class="bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl shadow-lg overflow-hidden mb-6">
        <div class="p-8 relative">
            <div class="flex items-center gap-6">
                {{-- Profile Photo --}}
                <div class="relative">
                    <div class="w-28 h-28 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="{{ $user->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <img src="https://i.pravatar.cc/200?u={{ $user->id }}" 
                                 alt="{{ $user->name }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 bg-green-400 rounded-full border-4 border-white"></div>
                </div>

                {{-- User Info --}}
                <div class="flex-1 text-white">
                    <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>
                    
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $user->address ?? 'Bandung' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Bergabung Sejak {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Edit Button (Only for own profile) --}}
                @if($isOwnProfile)
                <a href="{{ route('profile.edit') }}" 
                   class="absolute top-6 right-6 bg-white text-cyan-600 px-4 py-2 rounded-xl font-semibold hover:bg-cyan-50 transition shadow">
                    Edit Profil
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column - Stats & Info --}}
        <div class="space-y-6">

            {{-- Personal Information Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-50 to-blue-50 px-5 py-4 border-b border-cyan-100">
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <span>👤</span> Informasi Pribadi
                    </h3>
                </div>
                
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $user->phone }}</p>
                    </div>

                    @if($user->dob)
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($user->dob)->format('d F Y') }}</p>
                    </div>
                    @endif

                    @if($user->address)
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Alamat</p>
                        <p class="font-semibold text-gray-900">{{ $user->address }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Right Column - Activity Feed with Tabs --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- Tab Navigation (X-style) --}}
                <div class="flex border-b border-gray-200">
                    <a href="{{ $isOwnProfile ? route('profile.index', ['tab' => 'postingan']) : route('profile.show', ['id' => $user->id, 'tab' => 'postingan']) }}" 
                       class="flex-1 text-center py-4 font-semibold transition-all relative
                              {{ $tab === 'postingan' ? 'text-cyan-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Postingan
                        </span>
                        @if($tab === 'postingan')
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-cyan-600 rounded-t"></div>
                        @endif
                    </a>

                    <a href="{{ $isOwnProfile ? route('profile.index', ['tab' => 'balasan']) : route('profile.show', ['id' => $user->id, 'tab' => 'balasan']) }}" 
                       class="flex-1 text-center py-4 font-semibold transition-all relative
                              {{ $tab === 'balasan' ? 'text-cyan-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Balasan
                        </span>
                        @if($tab === 'balasan')
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-cyan-600 rounded-t"></div>
                        @endif
                    </a>

                    <a href="{{ $isOwnProfile ? route('profile.index', ['tab' => 'suka']) : route('profile.show', ['id' => $user->id, 'tab' => 'suka']) }}" 
                       class="flex-1 text-center py-4 font-semibold transition-all relative
                              {{ $tab === 'suka' ? 'text-cyan-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Suka
                        </span>
                        @if($tab === 'suka')
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-cyan-600 rounded-t"></div>
                        @endif
                    </a>
                </div>

                {{-- Tab Content --}}
                <div class="divide-y divide-gray-100">
                    @forelse($content as $item)
                    <div class="p-5 hover:bg-gray-50 transition">
                        
                        {{-- Jika Tab Balasan, Tampilkan Context --}}
                        @if($tab === 'balasan' && $item->parent)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg border-l-4 border-gray-300">
                                <div class="flex items-center gap-2 mb-1">
                                    <a href="{{ route('profile.show', $item->parent->user->id) }}" class="flex-shrink-0">
                                        @if($item->parent->user && $item->parent->user->profile_photo)
                                            <img src="{{ asset('storage/' . $item->parent->user->profile_photo) }}" 
                                                 alt="{{ $item->parent->user->name }}"
                                                 class="w-6 h-6 rounded-full object-cover hover:ring-2 hover:ring-cyan-400 transition">
                                        @else
                                            <img src="https://i.pravatar.cc/40?u={{ $item->parent->user->id }}" 
                                                 alt="{{ $item->parent->user->name }}"
                                                 class="w-6 h-6 rounded-full object-cover hover:ring-2 hover:ring-cyan-400 transition">
                                        @endif
                                    </a>
                                    <a href="{{ route('profile.show', $item->parent->user->id) }}" class="text-sm font-semibold text-gray-700 hover:text-cyan-600 transition">
                                        {{ $item->parent->user->name }}
                                    </a>
                                    <span class="text-xs text-gray-500">• {{ $item->parent->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ Str::limit($item->parent->content, 100) }}</p>
                            </div>
                        @endif
                        
                        <div class="flex items-start gap-3">
                            <a href="{{ route('profile.show', $item->user->id) }}" class="flex-shrink-0">
                                @if($item->user && $item->user->profile_photo)
                                    <img src="{{ asset('storage/' . $item->user->profile_photo) }}" 
                                         alt="{{ $item->user->name }}"
                                         class="w-10 h-10 rounded-full object-cover hover:ring-2 hover:ring-cyan-400 transition">
                                @else
                                    <img src="https://i.pravatar.cc/50?u={{ $item->user->id }}" 
                                         alt="{{ $item->user->name }}"
                                         class="w-10 h-10 rounded-full object-cover hover:ring-2 hover:ring-cyan-400 transition">
                                @endif
                            </a>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <a href="{{ route('profile.show', $item->user->id) }}" class="font-bold text-gray-900 hover:text-cyan-600 transition">
                                        {{ $item->user->name }}
                                    </a>
                                    <span class="text-gray-400">•</span>
                                    <p class="text-sm text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                    
                                    @if($tab === 'balasan')
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                            Membalas
                                        </span>
                                    @elseif($tab === 'suka')
                                        <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">
                                            ❤️ Disukai
                                        </span>
                                    @endif
                                </div>

                                @if($item->title)
                                <h4 class="font-bold text-gray-900 mb-1">{{ $item->title }}</h4>
                                @endif

                                <p class="text-gray-700 text-sm mb-3">
                                    {{ Str::limit($item->content, 200) }}
                                </p>

                                @if($item->image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="Post image"
                                         class="w-full max-h-64 rounded-lg border object-cover">
                                </div>
                                @endif

                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $item->likes->count() }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $item->replies->count() }}
                                    </span>
                                    <a href="{{ route('forum.show', $tab === 'balasan' && $item->parent_id ? $item->parent_id : $item->id) }}" 
                                       class="ml-auto text-cyan-600 hover:underline">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center">
                        @if($tab === 'postingan')
                            <div class="text-6xl mb-4">📝</div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada postingan</h3>
                            <p class="text-gray-500 mb-4">Mulai berbagi pengalaman dengan komunitas!</p>
                        @elseif($tab === 'balasan')
                            <div class="text-6xl mb-4">💬</div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada balasan</h3>
                            <p class="text-gray-500 mb-4">Mulai berinteraksi dengan postingan lain!</p>
                        @else
                            <div class="text-6xl mb-4">❤️</div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada yang disukai</h3>
                            <p class="text-gray-500 mb-4">Like postingan yang kamu suka!</p>
                        @endif
                        
                        <a href="{{ route('home') }}" 
                           class="inline-block px-6 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition">
                            Jelajahi Forum
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($content->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $content->appends(['tab' => $tab])->links() }}
                </div>
                @endif

            </div>
        </div>

    </div>

</div>
@endsection