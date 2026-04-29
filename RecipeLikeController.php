<?php
// ============================================================
// FILE: app/Http/Controllers/RecipeLikeController.php
// Task 20: Like toggle via AJAX
// ============================================================
namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class RecipeLikeController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function toggle(Recipe $recipe): JsonResponse
    {
        $user = auth()->user();
        $like = $recipe->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $recipe->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $recipe->likes()->count(),
        ]);
    }
}
