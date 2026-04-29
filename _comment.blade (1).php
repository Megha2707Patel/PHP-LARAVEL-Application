<div class="flex gap-3" id="comment-{{ $comment->id }}">
    <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}"
         class="w-9 h-9 rounded-full object-cover flex-shrink-0">
    <div class="flex-1 bg-stone-50 rounded-xl px-4 py-3">
        <div class="flex items-center justify-between mb-1">
            <span class="text-sm font-semibold text-stone-800">{{ $comment->user->name }}</span>
            <div class="flex items-center gap-3">
                <span class="text-xs text-stone-400">{{ $comment->created_at->diffForHumans() }}</span>
                @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                    <button onclick="deleteComment({{ $comment->id }})"
                            class="text-xs text-red-400 hover:text-red-600 transition">Delete</button>
                @endif
            </div>
        </div>
        <p class="text-sm text-stone-700">{{ $comment->body }}</p>
    </div>
</div>

<script>
async function deleteComment(id) {
    if (!confirm('Delete this comment?')) return;
    await fetch(`/comments/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    document.getElementById(`comment-${id}`).remove();
}
</script>
