<div>
    <button @click="$dispatch('open-modal', {  name: 'followers-modal' })"
        class="m-0 p-0 hover:underline"><b>{{ $count }}</b> Followers</button>

    <x-modal title="Followers ({{ $count }})" name="followers-modal">
        <ul class="profile-follow-modal">
            @foreach ($followers as $follower)
                <li>
                    @livewire('user-card', ['user' => $follower->user, 'isFollowing' => true], key($follower->user->id))
                </li>
            @endforeach
        </ul>
    </x-modal>
</div>
