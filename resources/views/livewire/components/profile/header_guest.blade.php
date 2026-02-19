<div class="profile-header-container">
    <div class="cover-container">
        <div class="cover-photo-container"
            @if ($user->profile?->cover_pic_path) @click="$wire.dispatch('open-image-viewer', {category: 'cover', category_id: null, id: {{ $user_id }}})" @endif>
            <img src="{{ $user->cover_pic }}" alt="cover-photo">
        </div>
    </div>

    <div class="profile-info-container">

        <div class="profile-img-container">
            <div class="w-full h-full"
                @if ($user->profile?->profile_pic_path) @click="$wire.dispatch('open-image-viewer', {category: 'profile', category_id: null, id: {{ $user_id }}})" @endif>
                <img src="{{ $user->profile_pic }}" alt="profile-user">
            </div>
        </div>

        <div class="profile-text-container">
            <div class="flex flex-col">
                <p class="profile-name">{{ $user->name }}
                </p>
                <p class="profile-username">{{ '@' . $user->username }}</p>
            </div>
            <div class="flex flex-col items-end gap-2 mt-1">
                <div class="flex gap-7">
                    <p><b>{{ $user->summary?->follower_count ?? 0 }}</b> Followers</p>
                    <p><b>{{ $user->summary?->following_count ?? 0 }}</b> Following</p>
                </div>
                <div class="me-1">
                    @if (auth()->user()->isFollowing($user))
                        <button class="button-square-secondary-1"
                            wire:click="handleUnfollow">Unfollow</button>
                    @else
                        <button class="button-square-main-1" wire:click="handleFollow">Follow</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
