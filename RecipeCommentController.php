<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeCommentController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function store(Request $request, Recipe $recipe)
    {
        $request->validate(['body' => ['required', 'string', 'max:1000']]);

        $comment = $recipe->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        $comment->load('user');

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('recipes._comment', compact('comment'))->render(),
                'count' => $recipe->comments()->count(),
            ]);
        }

        return back()->with('success', 'Comment added!');
    }

    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return response()->json(['deleted' => true]);
    }
}
