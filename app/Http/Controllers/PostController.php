<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
     public function index(){
         $posts = Post::all();

        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }
}
