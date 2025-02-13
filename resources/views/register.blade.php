@extends('layouts.app')

@push('styles')
    @vite('resources/css/register.css')
@endpush

@section('title', 'Create an Account')

@section('content')
    <div class="register-page-container">
        <div class="highlights-container">
            <img src="https://picsum.photos/900/900" alt="features">
        </div>
        <main class="register-content">
            <div>
                <h1>Create an Account</h1>
                <h2>Welcome! Please complete the form to register.</h2>
            </div>
            <form action="" class="register-form">
                @csrf

                <div class="register-fields-container">
                    <div class="name-input-container">
                        <div class="input-field">
                            <label for="first-name">First Name</label>
                            <input type="text" name="first_name" id="first-name" placeholder="e.g. John" required>
                        </div>

                        <div class="input-field">
                            <label for="last-name">Last Name</label>
                            <input type="text" name="last_name" id="last-name" placeholder="e.g. Doe" required>
                        </div>
                    </div>

                    <div class="input-field">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter your Email Address here" required>
                    </div>

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
                </div>

                <div class="register-buttons-container">
                    <button id="register-button">Register</button>
                    <div>
                        <div class="line"></div>
                        <span>OR</span>
                        <div class="line"></div>
                    </div>
                    <button type="button" id="google-register-button"><span><img src="{{ asset('assets/icons/google.png') }}" alt="google"></span>
                        Continue with Google</button>
                </div>

                <p class="redirect-register-container">Already have an account? <a href="">Sign in</a></p>
            </form>
        </main>
    </div>
@endsection
