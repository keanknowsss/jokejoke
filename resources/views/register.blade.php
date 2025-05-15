@extends('layouts.app')

@push('styles')
    @vite('resources/css/register.css')
    @vite('resources/css/components/form.css')
    @vite('resources/css/auth_carousel.css')
@endpush

@section('title', 'Create an Account')

@section('content')
    <div class="register-page-container">

        <x-carousel-auth />

        <main class="register-content">
            <div>
                <h1>Create an Account</h1>
                <h2>Welcome! Please complete the form to register.</h2>
            </div>

            <form action="{{ route('user.register.store') }}" method="POST" class="register-form">
                @csrf

                <div class="register-fields-container">
                    <div class="name-input-container">
                        <div class="input-field">
                            <x-form-label for="first-name">First Name</x-form-label>
                            <x-form-input type="text" name="first_name" id="first-name" value="{{ old($first_name, '') }}"
                                placeholder="e.g. John" required />
                            <x-form-error name="first_name" />
                        </div>


                        <div class="input-field">
                            <x-form-label for="last-name">Last Name</x-form-label>
                            <x-form-input type="text" name="last_name" id="last-name" value="{{ old($last_name, '') }}"
                                placeholder="e.g. Doe" required />
                            <x-form-error name="last_name" />
                        </div>

                    </div>

                    <div class="input-field">
                        <x-form-label for="email">Email Address</x-form-label>
                        <x-form-input type="email" name="email" id="email" value="{{ old($email, '') }}"
                            placeholder="Enter your Email Address here" required />
                        <x-form-error name="email" />
                    </div>


                    <div class="input-field">
                        <x-form-label for="username">Username</x-form-label>
                        <x-form-input type="text" name="username" id="username" value="{{ old($username, '') }}"
                            placeholder="Enter your Username here" required />
                        <x-form-error name="username" />
                    </div>


                    <div class="input-field">
                        <x-form-label for="password">Password</x-form-label>
                        <x-form-input type="password" name="password" id="password" placeholder="Enter your Password" />
                        <x-form-error name="password" />
                    </div>
                </div>

                <div class="register-buttons-container">
                    <button id="register-button">Register</button>
                    <div>
                        <div class="line"></div>
                        <span>OR</span>
                        <div class="line"></div>
                    </div>
                    <button type="button" id="google-button" type="button"><span><img
                                src="{{ asset('assets/icons/google.png') }}" alt="google"></span>
                        Continue with Google</button>
                </div>

                <p class="redirect-register-container">Already have an account? <a href="{{ route('user.sign-in') }}">Sign
                        in</a></p>
            </form>
        </main>
    </div>

    @push('scripts')
        @vite('resources/js/auth_carousel.js')
    @endpush
@endsection
