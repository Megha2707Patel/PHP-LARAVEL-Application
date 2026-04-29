<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;

class RecipeBookmarkController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function toggle(Recipe $recipe): JsonResponse
    {
        $user = auth()->user();
        $bookmark = $recipe->bookmarks()->where('user_id', $user->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
        } else {
            $recipe->bookmarks()->create(['user_id' => $user->id]);
            $bookmarked = true;
        }

        return response()->json(['bookmarked' => $bookmarked]);
    }
}
