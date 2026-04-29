@props(['recipe'])

<div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-stone-100 group">
    <!-- Image -->
    <a href="{{ route('recipes.show', $recipe) }}" class="block overflow-hidden h-48">
        <img src="{{ $recipe->image_url }}"
             alt="{{ $recipe->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </a>

    <div class="p-4">
        <!-- Category + Difficulty -->
        <div class="flex items-center gap-2 mb-2">
            @if($recipe->category)
                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-medium">
                    {{ $recipe->category }}
                </span>
            @endif
            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                {{ $recipe->difficulty === 'easy' ? 'bg-green-100 text-green-700' : ($recipe->difficulty === 'hard' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                {{ ucfirst($recipe->difficulty) }}
            </span>
        </div>

        <!-- Title -->
        <a href="{{ route('recipes.show', $recipe) }}"
           class="font-display font-bold text-lg text-stone-800 hover:text-orange-500 transition line-clamp-2 block mb-2">
            {{ $recipe->title }}
        </a>

        <!-- Description -->
        <p class="text-stone-500 text-sm line-clamp-2 mb-3">{{ $recipe->description }}</p>

        <!-- Meta -->
        <div class="flex items-center justify-between text-xs text-stone-400">
            <div class="flex items-center gap-3">
                <span>⏱ {{ $recipe->total_time }}min</span>
                <span>👤 {{ $recipe->servings }} servings</span>
            </div>
            <div class="flex items-center gap-2">
                <span>❤️ {{ $recipe->likes_count }}</span>
                <span>💬 {{ $recipe->comments->count() }}</span>
            </div>
        </div>

        <!-- Author -->
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-stone-100">
            <img src="{{ $recipe->user->avatar_url }}" alt="{{ $recipe->user->name }}"
                 class="w-6 h-6 rounded-full object-cover">
            <a href="{{ route('profile.show', $recipe->user) }}"
               class="text-xs text-stone-500 hover:text-orange-500 transition">
                {{ $recipe->user->name }}
            </a>
        </div>
    </div>
</div>
