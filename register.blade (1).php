<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-3xl font-bold text-stone-800">Join Recipe Share</h1>
        <p class="text-stone-500 mt-1 text-sm">Start sharing your favorite recipes</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                          name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username (Task 3: new field) -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text"
                          name="username" :value="old('username')" required />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                          name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Bio (Task 3: new field) -->
        <div>
            <x-input-label for="bio" :value="__('Bio (optional)')" />
            <textarea id="bio" name="bio" rows="2"
                      placeholder="Tell us about your cooking style…"
                      class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-orange-400 focus:ring-orange-400 text-sm resize-none">{{ old('bio') }}</textarea>
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm text-stone-500 hover:text-orange-500 transition" href="{{ route('login') }}">
                Already have an account?
            </a>
            <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
