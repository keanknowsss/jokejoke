@extends('layouts.app')

@push('styles')
    @vite('resources/css/jokes.css')
@endpush

@section('title', 'Joke Feed')

@section('content')

    <div class="jokes-container">
        <section class="profile-bar"></section>
        <main class="feed-bar">
            <div class="post-container">
                <div class="user-info-post-container">
                    {{-- User posted --}}
                    <div class="sm-image-container">
                        <img src="https://picsum.photos/42" alt="user-name">
                    </div>
                    <div class="flex flex-col align-items-center justify-center">
                        <p class="font-bold post-name">Lorem Ipsum</p>
                        <p class="font-light post-time">2 hours ago</p>
                    </div>
                </div>
                <p class="text-sm mb-3">
                    {{-- caption --}}
                    Lorem ipsum dolor sit amet consectetur. Nisl mauris sagittis tortor quam sagittis laoreet mus.
                    Laoreet ultricies tempus nunc condimentum gravida lorem vestibulum pulvinar in. Suspendisse
                    proin non tellus vel. Volutpat egestas lectus augue purus arcu augue. Semper non malesuada
                    posuere eu laoreet rutrum ut dolor risus. Id.
                </p>
                <div class="post-attachment-container">
                    {{-- img container if there is img / file --}}
                    {{-- <img src="https://picsum.photos/900/600" alt="post-1-img"> --}}
                    <div class="attachment-content">
                        <p>Attachment Funny.pdf</p>
                        <p>2.3 MB</p>
                    </div>
                </div>
                <div class="other-post-buttons-container">
                    {{-- buttons --}}
                    <button><i class="fa-regular fa-face-laugh-squint"></i> <span class="text-sm">Haha</span></button>
                    <button><i class="fa-regular fa-comment"></i> <span class="text-sm">Comment</span></button>
                    <button><i class="fa-solid fa-share"></i> <span class="text-sm">Share</span></button>
                </div>
                <div>
                    {{-- comments-container --}}
                    <div class="ms-4 ">
                        <div class="other-comment-content">
                            <div class="xs-image-container"><img src="https://picsum.photos/32" alt="other-user-comment">
                            </div>
                            <div class="flex-1">
                                <p class="other-comment-name"><b>Lorem Ipsum</b></p>
                                <p class="other-comment">Lorem ipsum dolor sit amet consectetur. In sed felis quis
                                    mi sit sed pharetra mauris
                                    lacus. Lectus morbi quis dolor tristique nisl in lorem. Vitae sed ut risus elit
                                    urna
                                    id praesent netus tellus. Velit in nec nisl proin.</p>
                                <p class="other-comment-time">5 minutes ago</p>
                            </div>
                        </div>
                        <div class="other-post-buttons-container ms-8">
                            {{-- buttons --}}
                            <button><i class="fa-regular fa-face-laugh-squint"></i> <span
                                    class="text-sm">Haha</span></button>
                            <button><i class="fa-regular fa-comment"></i> <span class="text-sm">Comment</span></button>
                        </div>
                    </div>
                </div>
                <div class="post-comment-container">
                    {{-- comment-container --}}
                    <div class="comment-text-container">
                        <div class="xs-image-container"><img src="https://picsum.photos/32" alt="user-comment">
                        </div>
                        <textarea name="" id="" placeholder="Here's my comment..."></textarea>
                        <button><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                    <div></div>
                </div>
            </div>
            <div class="post-container">
                <div class="user-info-post-container">
                    {{-- User posted --}}
                    <div class="sm-image-container">
                        <img src="https://picsum.photos/42" alt="user-name">
                    </div>
                    <div class="flex flex-col align-items-center justify-center">
                        <p class="font-bold post-name">Lorem Ipsum</p>
                        <p class="font-light post-time">2 hours ago</p>
                    </div>
                </div>
                <p class="text-sm mb-3">
                    {{-- caption --}}
                    Lorem ipsum dolor sit amet consectetur. Nisl mauris sagittis tortor quam sagittis laoreet mus.
                    Laoreet ultricies tempus nunc condimentum gravida lorem vestibulum pulvinar in. Suspendisse
                    proin non tellus vel. Volutpat egestas lectus augue purus arcu augue. Semper non malesuada
                    posuere eu laoreet rutrum ut dolor risus. Id.
                </p>
                <div class="post-attachment-container">
                    <img src="https://picsum.photos/900/600" alt="post-1-img">
                </div>

                <div class="other-post-buttons-container">
                    {{-- buttons --}}
                    <button><i class="fa-regular fa-face-laugh-squint"></i> <span class="text-sm">Haha</span></button>
                    <button><i class="fa-regular fa-comment"></i> <span class="text-sm">Comment</span></button>
                    <button><i class="fa-solid fa-share"></i> <span class="text-sm">Share</span></button>
                </div>
                <div>
                    {{-- comments-container --}}
                    <div class="ms-4 ">
                        <div class="other-comment-content">
                            <div class="xs-image-container"><img src="https://picsum.photos/32" alt="other-user-comment">
                            </div>
                            <div class="flex-1">
                                <p class="other-comment-name"><b>Lorem Ipsum</b></p>
                                <p class="other-comment">Lorem ipsum dolor sit amet consectetur. In sed felis quis
                                    mi sit sed pharetra mauris
                                    lacus. Lectus morbi quis dolor tristique nisl in lorem. Vitae sed ut risus elit
                                    urna
                                    id praesent netus tellus. Velit in nec nisl proin.</p>
                                <p class="other-comment-time">5 minutes ago</p>
                            </div>
                        </div>
                        <div class="other-post-buttons-container ms-8">
                            {{-- buttons --}}
                            <button><i class="fa-regular fa-face-laugh-squint"></i> <span
                                    class="text-sm">Haha</span></button>
                            <button><i class="fa-regular fa-comment"></i> <span class="text-sm">Comment</span></button>
                        </div>
                    </div>
                </div>
                <div class="post-comment-container">
                    {{-- comment-container --}}
                    <div class="comment-text-container">
                        <div class="xs-image-container"><img src="https://picsum.photos/32" alt="user-comment">
                        </div>
                        <textarea name="" id="" placeholder="Here's my comment..."></textarea>
                        <button><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                    <div></div>
                </div>
            </div>
        </main>
        <section class="link-container">
            <div>
                <p>Want to share jokes?</p>
                <a href="" class="btn-link">Login</a>
            </div>
            <div>
                <p>Create an account.</p>
                <a href="" class="btn-link">Register</a>
            </div>
        </section>
    </div>

@endsection
