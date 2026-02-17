<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class UserSuggestion extends Component
{
    public Collection $users;

    public function handleFollow(User $user)
    {
        if (auth()->id() === $user->id) {
            return;
        }

        auth()->user()->follow($user);

        $this->dispatch('userFollowed', [
            'status' => 'success',
            'message' => "{$user->first_name} followed successfully!"
        ]);
    }

    public function mount()
    {
        $this->users = User::whereNot('id', auth()->id())
            ->limit(5)
            ->inRandomOrder()
            ->get();
    }

    public function render()
    {
        return view('livewire.user-suggestion');
    }
}
