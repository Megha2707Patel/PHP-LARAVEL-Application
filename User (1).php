<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'bio', 'avatar', 'is_admin',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // Relationships
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function bookmarkedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'bookmarks');
    }

    public function likedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'likes');
    }

    // Helpers
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function hasLiked(Recipe $recipe): bool
    {
        return $this->likes()->where('recipe_id', $recipe->id)->exists();
    }

    public function hasBookmarked(Recipe $recipe): bool
    {
        return $this->bookmarks()->where('recipe_id', $recipe->id)->exists();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }
}
