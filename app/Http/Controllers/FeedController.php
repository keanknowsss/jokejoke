<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

use function Pest\Laravel\isAuthenticated;

class FeedController extends Controller
{
    public function index() {
        $posts = Post::with('user')->get();

        return view('feed', [
            'posts' => $posts
        ]);
    }
}
