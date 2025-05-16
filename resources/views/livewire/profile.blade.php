@push('styles')
    @vite(['resources/css/profile.css', 'resources/css/components/post.css', 'resources/css/components/form.css'])
@endpush

<div>
    @livewire('image-viewer')


    <div class="profile-page-container" x-data="{ display: 'jokes' }">
        @livewire('sidebar')

        <section class="profile-content">
            <div class="profile-header-container">
                <div class="cover-photo-container" @click="$wire.dispatch('open-image-viewer', {category: 'cover', category_id: null, id: {{ auth()->user()->id }}})">
                    <img src="{{ Storage::url(auth()->user()->profile->cover_pic_path) }}" alt="cover-photo">
                </div>
                <div class="profile-info-container">
                    <div class="profile-img-container" @click="$wire.dispatch('open-image-viewer', {category: 'profile', category_id: null, id: {{ auth()->user()->id }}})">
                        <img src="{{ Storage::url(auth()->user()->profile->profile_pic_path) }}" alt="profile-user">
                    </div>
                    <div class="profile-text-container">
                        <div class="flex flex-col">
                            <p class="profile-name">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                            </p>
                            <p class="profile-username">{{ '@' . auth()->user()->username }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p><b>1.25k</b> Followers</p>
                            <p><b>1.25k</b> Following</p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="profile-description">{{ auth()->user()->profile->bio }}</p>
            <div class="profile-btn-container">
                <button :class="{ 'active': display === 'jokes' }" @click="display = 'jokes'">My Jokes</button>
                <button :class="{ 'active': display === 'about' }" @click="display = 'about'">About</button>
            </div>
            <hr class="divider">
            <div class="profile-feed-container">
                <div class="profile-feed">
                    <div x-show="display === 'jokes'" x-transition>
                        @livewire('post-form')

                        @livewire('post-container', [
                            'user_id' => auth()->user()->id,
                        ])
                    </div>
                    <div x-show="display === 'about'" x-transition x-cloak>
                        @livewire('components.profile.about')
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
