<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\RecipeBookmarkController;
use App\Http\Controllers\RecipeCommentController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeLikeController;
use Illuminate\Support\Facades\Route;

// ─── Public ─────────────────────────────────────────────────
Route::get('/', [RecipeController::class, 'index'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// ─── Authenticated ───────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Recipe dashboard & CRUD
    Route::get('/dashboard', [RecipeController::class, 'dashboard'])->name('recipes.dashboard');
    Route::resource('recipes', RecipeController::class)->except(['index', 'show']);

    // Interactions
    Route::post('/recipes/{recipe}/like',     [RecipeLikeController::class,     'toggle'])->name('recipes.like');
    Route::post('/recipes/{recipe}/bookmark', [RecipeBookmarkController::class, 'toggle'])->name('recipes.bookmark');
    Route::post('/recipes/{recipe}/comments', [RecipeCommentController::class,  'store'])->name('recipes.comments.store');
    Route::delete('/comments/{comment}',      [RecipeCommentController::class,  'destroy'])->name('comments.destroy');

    // User profile
    Route::get('/profile/{user}', function (\App\Models\User $user) {
        return view('profile.show', compact('user'));
    })->name('profile.show');
});

// ─── Admin ───────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);
    Route::get('/recipes', function () {
        $recipes = \App\Models\Recipe::with('user')->latest()->paginate(20);
        return view('admin.recipes.index', compact('recipes'));
    })->name('recipes.index');
});

// ─── Auth routes (Breeze) ────────────────────────────────────
require __DIR__ . '/auth.php';
