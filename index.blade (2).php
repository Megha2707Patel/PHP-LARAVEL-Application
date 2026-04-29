@extends('layouts.app')
@section('title', 'Admin — Recipes')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-display text-3xl font-bold text-stone-800">All Recipes</h1>
        <a href="{{ route('admin.users.index') }}"
           class="border border-stone-300 px-4 py-2 rounded-xl text-sm text-stone-700 hover:bg-stone-50 transition">
            Manage Users
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-stone-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="text-left px-6 py-4">Recipe</th>
                    <th class="text-left px-6 py-4">Author</th>
                    <th class="text-left px-6 py-4">Category</th>
                    <th class="text-left px-6 py-4">Likes</th>
                    <th class="text-left px-6 py-4">Comments</th>
                    <th class="text-left px-6 py-4">Date</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($recipes as $recipe)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="px-6 py-4">
                            <a href="{{ route('recipes.show', $recipe) }}"
                               class="font-medium text-stone-800 hover:text-orange-500 transition">
                                {{ $recipe->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-stone-500">{{ $recipe->user->name }}</td>
                        <td class="px-6 py-4 text-stone-400">{{ $recipe->category ?? '—' }}</td>
                        <td class="px-6 py-4 text-stone-500">{{ $recipe->likes_count }}</td>
                        <td class="px-6 py-4 text-stone-500">{{ $recipe->comments()->count() }}</td>
                        <td class="px-6 py-4 text-stone-400">{{ $recipe->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <x-delete-confirm-modal :action="route('recipes.destroy', $recipe)"
                                                    label="Del"
                                                    message="Delete '{{ $recipe->title }}'?" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $recipes->links() }}</div>
</div>
@endsection
