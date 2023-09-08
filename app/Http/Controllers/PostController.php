<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\RoleBasedScope; // Import your RoleBasedScope model
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Conditionally apply the scope if the route doesn't match the excluded ones
        if (!$request->is('api/posts/*')) {
            $posts = Post::withoutGlobalScope(RoleBasedScope::class)->get();
        } else {
            $posts = Post::all(); // Apply the scope for other routes
        }

        return response()->json($posts);
    }

    public function show(Request $request, $id)
    {
        // Conditionally apply the scope if the route doesn't match the excluded ones
        if (!$request->is('api/posts/*')) {
            $post = Post::withoutGlobalScope(RoleBasedScope::class)->findOrFail($id);
        } else {
            $post = Post::findOrFail($id); // Apply the scope for other routes
        }

        return response()->json($post);
    }
}
