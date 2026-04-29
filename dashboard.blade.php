@extends('layouts.app')
@section('title', 'My Recipes')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-3xl font-bold text-stone-800">My Recipes</h1>
            <p class="text-stone-500 mt-1">Manage your culinary creations</p>
        </div>
        <a href="{{ route('recipes.create') }}"
           class="bg-orange-500 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-orange-600 transition">
            + New Recipe
        </a>
    </div>

    @if($recipes->count())
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-stone-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-4">Recipe</th>
                        <th class="text-left px-6 py-4">Category</th>
                        <th class="text-left px-6 py-4">Difficulty</th>
                        <th class="text-left px-6 py-4">Likes</th>
                        <th class="text-left px-6 py-4">Created</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($recipes as $recipe)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}"
                                         class="w-12 h-12 rounded-lg object-cover">
                                    <a href="{{ route('recipes.show', $recipe) }}"
                                       class="font-medium text-stone-800 hover:text-orange-500 transition">
                                        {{ $recipe->title }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-stone-500">{{ $recipe->category ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full text-xs
                                    {{ $recipe->difficulty === 'easy' ? 'bg-green-100 text-green-700' : ($recipe->difficulty === 'hard' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($recipe->difficulty) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-stone-500">❤️ {{ $recipe->likes_count }}</td>
                            <td class="px-6 py-4 text-stone-400">{{ $recipe->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('recipes.edit', $recipe) }}"
                                       class="text-stone-500 hover:text-orange-500 transition text-xs font-medium">Edit</a>
                                    <x-delete-confirm-modal :action="route('recipes.destroy', $recipe)"
                                                            label="Del"
                                                            message="Delete '{{ $recipe->title }}'?" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $recipes->links() }}</div>
    @else
        <div class="text-center py-24 bg-white rounded-2xl border border-stone-100">
            <div class="text-6xl mb-4">🥘</div>
            <h2 class="font-display text-2xl font-bold text-stone-700 mb-2">No recipes yet</h2>
            <p class="text-stone-400 mb-6">Share your first recipe with the world!</p>
            <a href="{{ route('recipes.create') }}"
               class="bg-orange-500 text-white px-6 py-3 rounded-xl font-medium hover:bg-orange-600 transition">
                Create Recipe
            </a>
        </div>
    @endif
</div>
@endsection
