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
            ])
            <div class="profile-btn-container">
                @if ($user->profile)
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
                        ])
                    </div>
                </div>
                @livewire('user-suggestion')
            </div>
        </section>
    </div>
</div>
