@extends('layouts.app')
@section('title', 'Create Recipe')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="font-display text-3xl font-bold text-stone-800 mb-8">Create New Recipe</h1>

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data"
          class="space-y-6">
        @csrf

        <!-- Basic Info -->
        <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
            <h2 class="font-display font-bold text-stone-700 mb-4">Basic Information</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Recipe Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">Description *</label>
                    <textarea name="description" rows="3" required
                              class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300 resize-none">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Category</label>
                        <input type="text" name="category" value="{{ old('category') }}"
                               placeholder="e.g. Dinner, Dessert, Breakfast"
                               class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Difficulty *</label>
                        <select name="difficulty" required
                                class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300 bg-white">
                            <option value="easy" {{ old('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Prep Time (min) *</label>
                        <input type="number" name="prep_time" value="{{ old('prep_time', 15) }}" min="0" required
                               class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Cook Time (min) *</label>
                        <input type="number" name="cook_time" value="{{ old('cook_time', 30) }}" min="0" required
                               class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Servings *</label>
                        <input type="number" name="servings" value="{{ old('servings', 4) }}" min="1" required
                               class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo Upload -->
        <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
            <h2 class="font-display font-bold text-stone-700 mb-4">Recipe Photo</h2>
            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 transition">
        </div>

        <!-- Instructions -->
        <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm">
            <h2 class="font-display font-bold text-stone-700 mb-4">Instructions *</h2>
            <textarea name="instructions" rows="10" required
                      placeholder="Step 1: Preheat oven to 375°F...&#10;Step 2: Mix together..."
                      class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300 resize-none font-mono text-sm">{{ old('instructions') }}</textarea>
        </div>

        <!-- Ingredients (Alpine.js dynamic) -->
        <div class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm"
             x-data="ingredientSelector()">
            <h2 class="font-display font-bold text-stone-700 mb-4">Ingredients</h2>

            <div class="mb-4">
                <input type="text" x-model="search"
                       placeholder="Search ingredients…"
                       class="w-full border border-stone-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300">
            </div>

            <!-- Available ingredients grouped by category -->
            <div class="grid grid-cols-2 gap-6 mb-6 max-h-64 overflow-y-auto">
                @foreach($ingredients as $category => $items)
                    <div>
                        <p class="text-xs font-semibold text-stone-400 uppercase mb-2">{{ $category }}</p>
                        @foreach($items as $ingredient)
                            <label class="flex items-center gap-2 text-sm py-1 hover:bg-stone-50 rounded cursor-pointer"
                                   x-show="!search || '{{ strtolower($ingredient->name) }}'.includes(search.toLowerCase())">
                                <input type="checkbox" class="rounded"
                                       @change="toggleIngredient({{ $ingredient->id }}, '{{ $ingredient->name }}', $event)">
                                {{ $ingredient->name }}
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <!-- Selected ingredients with qty/unit -->
            <div x-show="selected.length > 0" class="border-t border-stone-100 pt-4 space-y-2">
                <p class="text-xs font-semibold text-stone-400 uppercase mb-2">Selected</p>
                <template x-for="(item, index) in selected" :key="item.id">
                    <div class="flex items-center gap-3 bg-orange-50 rounded-xl px-4 py-2">
                        <span class="flex-1 text-sm text-stone-700" x-text="item.name"></span>
                        <input type="hidden" :name="`ingredients[${index}][id]`" :value="item.id">
                        <input type="text" :name="`ingredients[${index}][quantity]`"
                               placeholder="Qty" class="w-16 border border-stone-300 rounded-lg px-2 py-1 text-xs focus:outline-none">
                        <input type="text" :name="`ingredients[${index}][unit]`"
                               placeholder="Unit" class="w-20 border border-stone-300 rounded-lg px-2 py-1 text-xs focus:outline-none">
                        <button type="button" @click="removeIngredient(item.id)" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                    </div>
                </template>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-3.5 rounded-xl font-semibold text-lg hover:bg-orange-600 transition">
            🍽️ Publish Recipe
        </button>
    </form>
</div>

@push('scripts')
<script>
function ingredientSelector() {
    return {
        search: '',
        selected: [],
        toggleIngredient(id, name, event) {
            if (event.target.checked) {
                this.selected.push({ id, name });
            } else {
                this.removeIngredient(id);
            }
        },
        removeIngredient(id) {
            this.selected = this.selected.filter(i => i.id !== id);
        }
    }
}
</script>
@endpush
@endsection
