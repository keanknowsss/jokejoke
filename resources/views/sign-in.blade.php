@extends('layouts.app')

@push('styles')
    @vite('resources/css/sign-in.css')
@endpush

@section('title', 'Sign In')

@section('content')
    <div class="sign-in-page-container">
        <div class="highlights-container">
            <img src="https://picsum.photos/900/900" alt="features">
        </div>
        <main class="sign-in-content">
            <div>
                <h1>Sign in</h1>
                <h2>Welcome! Please enter your credentials to sign in.</h2>
            </div>
            <form action="" class="sign-in-form">
                @csrf

                <div class="sign-in-fields-container">
                    <div class="input-field">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Enter your Username here" required>
                    </div>

                    <div class="input-field">
                        <label for="password">Password</label>
                        <div class="password-field">
                            <input type="password" name="password" id="password" placeholder="Enter your Password">
                            <button type="button">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button type="button" style="display: none;">
                                <i class="fa-regular fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between w-full px-2">
                        <div>
                            <input type="checkbox" name="remember_password" id="remember-password">
                            <label for="remember-password">Remember Password</label>
                        </div>
                        <button type="button" class="btn-link">
                            Forgot Password
                        </button>
                    </div>
                </div>

                <div class="sign-in-buttons-container">
                    <button id="sign-in-button">Sign in</button>
                    <div>
                        <div class="line"></div>
                        <span>OR</span>
                        <div class="line"></div>
                    </div>
                    <button type="button" id="google-sign-in-button"><span><img src="{{ asset('assets/icons/google.png') }}" alt="google"></span>
                        Sign up with Google</button>
                </div>

                <p class="redirect-register-container">Don't have an account? <a href="">Register</a></p>
            </form>
        </main>
    </div>
@endsection
