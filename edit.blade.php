@extends('layouts.app')
@section('title', 'Edit User — ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <a href="{{ route('admin.users.index') }}" class="text-orange-500 hover:underline text-sm mb-6 inline-block">
        ← Back to Users
    </a>
    <h1 class="font-display text-3xl font-bold text-stone-800 mb-8">Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST"
          class="bg-white rounded-2xl border border-stone-100 p-6 shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                   class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Bio</label>
            <textarea name="bio" rows="3"
                      class="w-full border border-stone-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-300 resize-none">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
            Save Changes
        </button>
    </form>
</div>
@endsection
