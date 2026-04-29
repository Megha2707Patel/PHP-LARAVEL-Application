<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use App\Models\Recipe;
use App\Models\User;
use App\Policies\RecipePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Policies
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Recipe::class, RecipePolicy::class);

        // Admin gate shortcut
        Gate::define('admin', fn (User $user) => $user->isAdmin());

        // Events
        Event::listen(UserRegistered::class, SendWelcomeEmail::class);
    }
}
