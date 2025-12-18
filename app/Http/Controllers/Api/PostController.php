<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->latest('published_at')
            ->get();

        return PostResource::collection($posts);
    }

    public function show($slug)
    {
        $post = Post::query()
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('slug', $slug)
            // ->with(['author', 'category', 'tags'])
            ->firstOrFail();

        // var_dump($post);

        return new PostResource($post);
    }
}
