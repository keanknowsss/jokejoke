<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Pest\Laravel\isAuthenticated;

class FeedController extends Controller
{
    public function index() {
        return view('feed');
    }
}
