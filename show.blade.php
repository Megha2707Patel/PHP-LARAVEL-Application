@extends('layouts.app')
@section('title', $recipe->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <!-- Back -->
    <a href="{{ route('recipes.index') }}" class="text-orange-500 hover:underline text-sm mb-6 inline-block">
        ← Back to recipes
    </a>

    <!-- Hero Image -->
    <div class="rounded-2xl overflow-hidden mb-8 h-80">
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Title & Meta -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="font-display text-3xl font-bold text-stone-800">{{ $recipe->title }}</h1>
                    <div class="flex items-center gap-2 mt-2">
                        @if($recipe->category)
                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full">{{ $recipe->category }}</span>
                        @endif
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $recipe->difficulty === 'easy' ? 'bg-green-100 text-green-700' : ($recipe->difficulty === 'hard' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($recipe->difficulty) }}
                        </span>
                    </div>
                </div>

                @can('update', $recipe)
                    <div class="flex gap-3">
                        <a href="{{ route('recipes.edit', $recipe) }}"
                           class="text-sm text-stone-600 border border-stone-300 px-3 py-1.5 rounded-lg hover:bg-stone-50 transition">
                            ✏️ Edit
                        </a>
                        <x-delete-confirm-modal :action="route('recipes.destroy', $recipe)"
                                                message="This will permanently delete '{{ $recipe->title }}'." />
                    </div>
                @endcan
            </div>

            <!-- Description -->
            <p class="text-stone-600 mb-6 leading-relaxed">{{ $recipe->description }}</p>

            <!-- Instructions -->
            <h2 class="font-display text-xl font-bold text-stone-800 mb-3">Instructions</h2>
            <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed whitespace-pre-line">
                {{ $recipe->instructions }}
            </div>

            <!-- ─── Comments Section (Task 21) ─── -->
            <div class="mt-10" id="comments-section"
                 x-data="commentsApp({{ $recipe->id }}, {{ $recipe->comments->count() }})">
                <h2 class="font-display text-xl font-bold text-stone-800 mb-4">
                    Comments (<span x-text="count"></span>)
                </h2>

                @auth
                    <form @submit.prevent="submitComment" class="mb-6">
                        <textarea x-model="body"
                                  placeholder="Share your thoughts or tips…"
                                  rows="3"
                                  class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300 resize-none"></textarea>
                        <button type="submit"
                                class="mt-2 bg-orange-500 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                            Post Comment
                        </button>
                    </form>
                @else
                    <p class="text-stone-500 text-sm mb-6">
                        <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Log in</a> to leave a comment.
                    </p>
                @endauth

                <!-- Comment List -->
                <div id="comment-list" class="space-y-4">
                    @foreach($recipe->comments as $comment)
                        @include('recipes._comment', ['comment' => $comment])
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Stats Card -->
            <div class="bg-white rounded-2xl border border-stone-100 p-5 mb-5 shadow-sm">
                <div class="grid grid-cols-3 gap-3 text-center mb-4">
                    <div>
                        <p class="text-2xl font-bold text-orange-500">{{ $recipe->prep_time }}</p>
                        <p class="text-xs text-stone-400">Prep (min)</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-orange-500">{{ $recipe->cook_time }}</p>
                        <p class="text-xs text-stone-400">Cook (min)</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-orange-500">{{ $recipe->servings }}</p>
                        <p class="text-xs text-stone-400">Servings</p>
                    </div>
                </div>

                @auth
                <!-- Like Button (Task 20) -->
                <div x-data="likeButton({{ $recipe->id }}, {{ auth()->user()->hasLiked($recipe) ? 'true' : 'false' }}, {{ $recipe->likes_count }})">
                    <button @click="toggle()"
                            :class="liked ? 'bg-red-100 text-red-600 border-red-200' : 'bg-stone-50 text-stone-600 border-stone-200'"
                            class="w-full flex items-center justify-center gap-2 border rounded-xl py-2.5 font-medium text-sm transition mb-2">
                        <span x-text="liked ? '❤️' : '🤍'"></span>
                        <span x-text="liked ? 'Liked' : 'Like'"></span>
                        <span x-text="'(' + count + ')'"></span>
                    </button>
                </div>

                <!-- Bookmark Button (Task 19) -->
                <div x-data="bookmarkButton({{ $recipe->id }}, {{ auth()->user()->hasBookmarked($recipe) ? 'true' : 'false' }})">
                    <button @click="toggle()"
                            :class="bookmarked ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : 'bg-stone-50 text-stone-600 border-stone-200'"
                            class="w-full flex items-center justify-center gap-2 border rounded-xl py-2.5 font-medium text-sm transition">
                        <span x-text="bookmarked ? '🔖' : '📄'"></span>
                        <span x-text="bookmarked ? 'Bookmarked' : 'Bookmark'"></span>
                    </button>
                </div>
                @endauth
            </div>

            <!-- Ingredients (Task 13) -->
            <div class="bg-white rounded-2xl border border-stone-100 p-5 shadow-sm">
                <h3 class="font-display font-bold text-stone-800 mb-3">Ingredients</h3>
                @if($recipe->ingredients->count())
                    <ul class="space-y-2">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="flex items-center justify-between text-sm text-stone-700 border-b border-stone-50 pb-1">
                                <span>{{ $ingredient->name }}</span>
                                <span class="text-stone-400">
                                    {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-stone-400 text-sm">No ingredients listed.</p>
                @endif
            </div>

            <!-- Author Card -->
            <div class="bg-white rounded-2xl border border-stone-100 p-5 shadow-sm mt-5">
                <p class="text-xs text-stone-400 uppercase font-medium mb-3">Recipe by</p>
                <a href="{{ route('profile.show', $recipe->user) }}" class="flex items-center gap-3 hover:opacity-80 transition">
                    <img src="{{ $recipe->user->avatar_url }}" alt="{{ $recipe->user->name }}"
                         class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-semibold text-stone-800">{{ $recipe->user->name }}</p>
                        <p class="text-xs text-stone-400">{{ $recipe->user->recipes()->count() }} recipes</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function likeButton(recipeId, initialLiked, initialCount) {
    return {
        liked: initialLiked,
        count: initialCount,
        async toggle() {
            const res = await fetch(`/recipes/${recipeId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            const data = await res.json();
            this.liked = data.liked;
            this.count = data.count;
        }
    }
}

function bookmarkButton(recipeId, initialBookmarked) {
    return {
        bookmarked: initialBookmarked,
        async toggle() {
            const res = await fetch(`/recipes/${recipeId}/bookmark`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            const data = await res.json();
            this.bookmarked = data.bookmarked;
        }
    }
}

function commentsApp(recipeId, initialCount) {
    return {
        body: '',
        count: initialCount,
        async submitComment() {
            if (!this.body.trim()) return;
            const res = await fetch(`/recipes/${recipeId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ body: this.body })
            });
            const data = await res.json();
            document.getElementById('comment-list').insertAdjacentHTML('afterbegin', data.html);
            this.count = data.count;
            this.body = '';
        }
    }
}
</script>
@endpush
@endsection
