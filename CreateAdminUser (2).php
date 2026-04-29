<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    protected $signature   = 'make:admin';
    protected $description = 'Create a new admin user interactively';

    public function handle(): void
    {
        $this->info('🍽️  Recipe App — Admin User Creator');
        $this->line('--------------------------------------');

        $name = $this->ask('Full name');

        $username = $this->ask('Username', Str::slug($name));
        while (User::where('username', $username)->exists()) {
            $this->warn("Username '{$username}' is already taken.");
            $username = $this->ask('Choose a different username');
        }

        $email = $this->ask('Email address');
        while (User::where('email', $email)->exists()) {
            $this->warn("Email '{$email}' is already registered.");
            $email = $this->ask('Use a different email');
        }

        $password = $this->secret('Password (hidden)');

        $user = User::create([
            'name'     => $name,
            'username' => $username,
            'email'    => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->newLine();
        $this->info("✅  Admin user created successfully!");
        $this->table(
            ['Field', 'Value'],
            [
                ['Name',     $user->name],
                ['Username', $user->username],
                ['Email',    $user->email],
                ['Role',     'Admin'],
            ]
        );
    }
}
