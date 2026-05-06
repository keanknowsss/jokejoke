<div>
    <button @click="$dispatch('open-modal', {  name: 'following-modal' })"
        class="m-0 p-0 hover:underline"><b>{{ $count }}</b> Following</button>

    <x-modal title="Following ({{ $count }})" name="following-modal">
        @if ($count > 0)
            <ul class="profile-follow-modal">
            @foreach ($following as $userFollowing)
                <li wire:key="{{ $userFollowing->id }}">
                    @livewire('user-card', ['user' => $userFollowing->follower, 'isFollowing' => true], key($userFollowing->id))
                </li>
            @endforeach
        </ul>
        @else
            <p class="text-gray-500 text-center">No users followed yet.</p>
        @endif

    </x-modal>
</div>
