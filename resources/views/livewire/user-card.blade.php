<div class="follow-user-container">
    <div class="follow-user-info">
        <div class="sm-image-container">
            <a href="{{ route('profile', ['user_id' => $user->id]) }}">
                <img src="{{ $user->profile_pic }}" alt="{{ $user->name }}">
            </a>
        </div>
        <div>
            <a href="{{ route('profile', ['user_id' => $user->id]) }}">
                <p class="font-bold other-name">{{ $user->name }}</p>
            </a>
            <p class="font-light other-username">{{ '@' . $user->username }}</p>
        </div>
    </div>
    @if ($isFollowing)
        <button wire:click="handleUnfollow" class="unfollow-btn">Unfollow</button>
    @else
        <button wire:click="handleFollow" class="follow-btn">Follow</button>
    @endif
</div>
