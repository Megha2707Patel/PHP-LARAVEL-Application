@extends('layouts.app')
@section('title', 'Admin — Users')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-3xl font-bold text-stone-800">User Management</h1>
            <p class="text-stone-500 mt-1">{{ $users->total() }} registered users</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.recipes.index') }}"
               class="border border-stone-300 px-4 py-2 rounded-xl text-sm text-stone-700 hover:bg-stone-50 transition">
                Manage Recipes
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-stone-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="text-left px-6 py-4">User</th>
                    <th class="text-left px-6 py-4">Email</th>
                    <th class="text-left px-6 py-4">Username</th>
                    <th class="text-left px-6 py-4">Recipes</th>
                    <th class="text-left px-6 py-4">Joined</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($users as $user)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                     class="w-9 h-9 rounded-full object-cover">
                                <span class="font-medium text-stone-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-stone-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-stone-500">@{{ $user->username }}</td>
                        <td class="px-6 py-4 text-stone-500">{{ $user->recipes()->count() }}</td>
                        <td class="px-6 py-4 text-stone-400">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-xs text-stone-600 hover:text-orange-500 transition font-medium">Edit</a>
                                <x-delete-confirm-modal :action="route('admin.users.destroy', $user)"
                                                        label="Del"
                                                        message="Delete {{ $user->name }}'s account and all their data?" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
