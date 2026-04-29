@extends('layouts.app')
@section('title', 'Browse Recipes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- Hero Search (Task 18) -->
    <div class="text-center mb-10">
        <h1 class="font-display text-4xl font-bold text-stone-800 mb-3">Discover Recipes</h1>
        <p class="text-stone-500 mb-6">Find inspiration for your next meal</p>

        <div class="max-w-xl mx-auto flex gap-3"
             x-data="recipeSearch()"
             x-init="init()">
            <input
                type="text"
                x-model="query"
                @input.debounce.400ms="search()"
                placeholder="Search by name, ingredient, or category…"
                class="flex-1 border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300 text-stone-800">

            <!-- Category filter -->
            <select x-model="category" @change="search()"
                    class="border border-stone-300 rounded-xl px-3 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300 bg-white text-stone-700">
                <option value="">All</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Recipe Grid -->
    <div id="recipe-grid">
        @include('recipes._grid', ['recipes' => $recipes])
    </div>
</div>

@push('scripts')
<script>
function recipeSearch() {
    return {
        query: '{{ request('search') }}',
        category: '{{ request('category') }}',

        init() {
            // Restore from URL params on page load
        },

        async search() {
            const params = new URLSearchParams();
            if (this.query)    params.set('search', this.query);
            if (this.category) params.set('category', this.category);

            // Update browser URL without reload
            window.history.replaceState({}, '', `${window.location.pathname}?${params}`);

            const res = await fetch(`{{ route('recipes.index') }}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await res.text();
            document.getElementById('recipe-grid').innerHTML = html;
        }
    }
}
</script>
@endpush
@endsection
