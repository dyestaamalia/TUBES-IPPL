@extends('layouts.app')

@section('title', 'Forum Comment')

@section('content')
<div class="max-w-3xl mx-auto px-4">

    <!-- Tombol Back: <- Postingan -->
    <div class="mb-4 flex items-center">
        <button 
            onclick="window.history.back()" 
            class="flex items-center text-blue-600 hover:text-blue-800 transition font-semibold"
        >
            <span class="text-xl mr-2">←</span> 
            Postingan
        </button>
    </div>

    <!-- Parent Comment + Replies -->
    <div class="space-y-6">
        @include('partials.comment', ['comment' => $comment, 'level' => 0])
    </div>

</div>

<!-- AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // LIKE
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.love-btn');
        if (!btn) return;
        e.stopPropagation();
        const id = btn.dataset.id;
        const count = btn.querySelector('.like-count');
        const token = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/comments/${id}/like`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token }
        })
        .then(res => res.json())
        .then(data => count.textContent = data.likes_count ?? 0)
        .catch(err => console.error(err));
    });

    // REPLY
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('.reply-btn');
        if (!btn) return;
        e.stopPropagation();
        const form = document.getElementById('reply-form-' + btn.dataset.id);
        form.classList.toggle('hidden');
    });

});
</script>
@endsection
