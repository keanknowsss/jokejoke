<div>
    @push('styles')
        @vite(['resources/css/profile.css', 'resources/css/components/post.css'])
    @endpush

    @section('content')
        <div class="profile-page-container">
            <livewire:sidebar />

            <section class="profile-content">
                <div class="profile-header-container">
                    <div class="cover-photo-container"><img src="https://picsum.photos/900/200" alt="cover-photo"></div>
                    <div class="profile-info-container">
                        <div class="profile-img-container"><img src="https://picsum.photos/180" alt="profile-user"></div>
                        <div class="profile-text-container">
                            <div class="flex flex-col">
                                <p class="profile-name">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
                                <p class="profile-username">{{ '@' . auth()->user()->username }}</p>
                            </div>
                            <div class="flex flex-col">
                                <p><b>1.25k</b> Followers</p>
                                <p><b>1.25k</b> Following</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="profile-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus sed
                    maiores exercitationem excepturi illum, impedit aliquam beatae molestias deserunt quidem. Vel ad cupiditate
                    laboriosam molestias pariatur officia dolorem possimus, et explicabo beatae corporis quis reprehenderit
                    cumque repellendus nobis sit at alias odit. Perspiciatis ullam possimus deserunt, illum quidem a neque!</p>
                <hr class="divider">
                <div class="profile-feed-container">
                    <div class="profile-feed">
                        @livewire('post-form')

                        @livewire('post-container', [
                            'user_id' => auth()->user()->id
                        ])
                    </div>
                    <div class="suggestions-bar">
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
                    </div>
                </div>
            </section>
        </div>
    @endsection
</div>
