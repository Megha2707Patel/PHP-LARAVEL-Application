<?php
// ============================================================
// FILE: app/Policies/UserPolicy.php
// ============================================================
namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser): bool  { return $authUser->isAdmin(); }
    public function view(User $authUser, User $user): bool { return $authUser->isAdmin() || $authUser->id === $user->id; }
    public function update(User $authUser, User $user): bool { return $authUser->isAdmin() || $authUser->id === $user->id; }
    public function delete(User $authUser, User $user): bool { return $authUser->isAdmin() && $authUser->id !== $user->id; }
}
