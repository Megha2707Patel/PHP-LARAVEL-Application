<?php
// ============================================================
// FILE: app/Http/Controllers/Auth/RegisteredUserController.php
// Replace the default Breeze version with this one.
// Task 1, 3, 4: Custom registration with extra fields + welcome email event
// ============================================================
namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'alpha_dash'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'bio'      => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'bio'      => $request->bio,
            'password' => Hash::make($request->password),
        ]);

        // Fire Laravel's built-in Registered event (for email verification if used)
        event(new Registered($user));

        // Fire our custom event → triggers SendWelcomeEmail listener
        event(new UserRegistered($user));

        Auth::login($user);

        return redirect(route('recipes.index'));
    }
}
