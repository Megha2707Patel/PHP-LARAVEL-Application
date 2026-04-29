@if($recipes->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($recipes as $recipe)
            <x-recipe-card :recipe="$recipe" />
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $recipes->links() }}
    </div>
@else
    <div class="text-center py-24">
        <div class="text-6xl mb-4">🍳</div>
        <h2 class="font-display text-2xl font-bold text-stone-700 mb-2">No recipes found</h2>
        <p class="text-stone-400">Try a different search term or browse all recipes.</p>
    </div>
@endif
