<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

use function Pest\Laravel\isAuthenticated;

class FeedController extends Controller
{
    public function index() {
        $posts = Post::with('user')->latest()->get();

        return view('feed', [
            'posts' => $posts,
            'title' => auth()->check() ? 'Joke Feed' : 'Joke! Have a laugh'
        ]);
    }
}
