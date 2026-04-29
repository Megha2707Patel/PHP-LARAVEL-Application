@extends('layouts.app')
@section('title', $user->name . '\'s Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Profile Header -->
    <div class="bg-white rounded-2xl border border-stone-100 p-8 shadow-sm mb-8 text-center">
        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
             class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-orange-100">
        <h1 class="font-display text-3xl font-bold text-stone-800">{{ $user->name }}</h1>
        <p class="text-stone-400 text-sm mb-3">@{{ $user->username }}</p>
        @if($user->bio)
            <p class="text-stone-600 max-w-md mx-auto">{{ $user->bio }}</p>
        @endif
        <div class="flex justify-center gap-8 mt-6 text-center">
            <div>
                <p class="text-2xl font-bold text-orange-500">{{ $user->recipes()->count() }}</p>
                <p class="text-xs text-stone-400">Recipes</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-orange-500">{{ $user->recipes()->withCount('likes')->get()->sum('likes_count') }}</p>
                <p class="text-xs text-stone-400">Likes Received</p>
            </div>
        </div>
    </div>

    <!-- User's Recipes -->
    <h2 class="font-display text-2xl font-bold text-stone-800 mb-6">Recipes by {{ $user->name }}</h2>

    @if($user->recipes()->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($user->recipes()->with('user')->latest()->get() as $recipe)
                <x-recipe-card :recipe="$recipe" />
            @endforeach
        </div>
    @else
        <div class="text-center py-16 text-stone-400">
            <div class="text-5xl mb-3">🧑‍🍳</div>
            <p>No recipes shared yet.</p>
        </div>
    @endif
</div>
@endsection
