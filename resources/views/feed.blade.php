@extends('layouts.app')

@push('styles')
    @vite(['resources/css/feed.css', 'resources/css/components/post.css'])
@endpush

@section('content')
    @livewire('image-viewer')

    <div class="feed-container">
        @livewire('sidebar')
        <main class="feed-bar">
            @auth
                @livewire('post-form')
            @endauth

            @livewire('post-container')
        </main>
        @auth
            @livewire('user-suggestion')
        @else
            <section class="link-container">
                <div>
                    <p>Want to share jokes?</p>
                    <a href="{{ route('user.sign-in') }}" class="btn-link">Login</a>
                </div>
                <div>
                    <p>Create an account.</p>
                    <a href="{{ route('user.register.index') }}" class="btn-link">Register</a>
                </div>
            </section>
        @endauth

    </div>

@endsection
