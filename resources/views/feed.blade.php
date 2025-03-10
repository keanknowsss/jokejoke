@extends('layouts.app')

@push('styles')
    @vite('resources/css/feed.css')
@endpush

@section('title', auth()->check() ? 'Joke Feed' : 'Joke! Have a laugh')

@section('content')
    <div class="feed-container">
        @livewire('sidebar')
        <main class="feed-bar">
            @auth
                @livewire('post-form')
            @endauth

            @livewire('post-container')
        </main>
        @auth
            <section class="suggestions-bar">
                @for ($i = 0; $i < 5; $i++)
                    <div class="follow-user-container">
                        <div class="follow-user-info">
                            <div class="sm-image-container">
                                <img src="https://picsum.photos/42" alt="user-name">
                            </div>
                            <div>
                                <p class="font-bold other-name">Lorem Ipsum</p>
                                <p class="font-light other-username">@username</p>
                            </div>
                        </div>
                        <button>Follow</button>
                    </div>
                @endfor

            </section>
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
