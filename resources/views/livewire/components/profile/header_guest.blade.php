<div class="profile-header-container" x-data="{ showProfilePicEditBtn: false }">
    <div class="cover-container">
        <div class="cover-photo-container"
            @if ($user->profile?->cover_pic_path) @click="$wire.dispatch('open-image-viewer', {category: 'cover', category_id: null, id: {{ $user_id }}})" @endif>
            <img src="{{ $user->cover_pic }}" alt="cover-photo">
        </div>
    </div>

    <div class="profile-info-container">

        <div class="profile-img-container" @mouseover="showProfilePicEditBtn = true"
            @mouseout="showProfilePicEditBtn = false">
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
            <div class="flex flex-col">
                <p><b>{{ $user->summary?->follower_count ?? 0 }}</b> Followers</p>
                <p><b>{{ $user->summary?->following_count ?? 0 }}</b> Following</p>
            </div>
        </div>
    </div>
</div>
