<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * returns view for the sign in page
     */
    public function create()
    {
        return view('sign-in');
    }

    /**
     * signs in the user and redirects to home page
     */
    public function store(LoginRequest $request)
    {
        // attempt
        if (!Auth::attempt($request->only(['username', 'password']))) {
            throw ValidationException::withMessages([
                'username' => 'Sorry, those credentials do not match. Please try again.'
            ]);
        }

        $request->session()->regenerate();

        return redirect(route('home'));
    }

    /**
     * signs out the user and redirects to sign in page
     */
    public function destroy()
    {
        Auth::logout();

        return redirect(route('user.sign-in'));
    }
}
