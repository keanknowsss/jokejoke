@push('styles')
    @vite(['resources/css/profile.css', 'resources/css/components/post.css', 'resources/css/components/form.css'])
@endpush

<div>
    @livewire('image-viewer')

    <div class="profile-page-container" x-data="{ display: '{{ $displayed_section }}' }">
        @livewire('sidebar')

        <section class="profile-content">
            @livewire('components.profile.header', [
                'user_id' => $user->id,
                'username' => $this->profile->username,
                'name' => $this->profile->name,
                'profile_pic' => $this->profile->profile_pic_path,
                'cover_pic' => $this->profile->cover_pic_path,
                'has_profile' => $has_profile
            ])
            <p class="profile-description">{{ $this->profile->bio }}</p>
            <div class="profile-btn-container">
                @if ($has_profile)
                    <button :class="{ 'active': display === 'jokes' }"
                        @click="display = 'jokes'">{{ $user->id === auth()->user()->id ? 'My Jokes' : 'Jokes' }}</button>
                @endif
                <button :class="{ 'active': display === 'about' }" @click="display = 'about'">About</button>
            </div>
            <hr class="divider">
            <div class="profile-feed-container">
                <div class="profile-feed">
                    <div x-show="display === 'jokes'" x-transition>
                        @if (auth()->user()->id === $user->id)
                            <div class="mb-5">@livewire('post-form')</div>
                        @endif

                        @livewire('post-container', [
                            'user_id' => $user->id,
                        ])
                    </div>
                    <div x-show="display === 'about'" x-transition x-cloak>
                        @livewire('components.profile.about', [
                            'user_id' => $user->id,
                            'username' => $this->profile->username,
                            'first_name' => $this->profile->first_name,
                            'last_name' => $this->profile->last_name,
                            'email' => $this->profile->email,
                            'birthdate' => $this->profile->birthdate,
                            'bio' => $this->profile->bio,
                            'date_joined' => $this->profile->date_joined,
                            'has_profile' => $has_profile
                        ])
                    </div>
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
</div>
