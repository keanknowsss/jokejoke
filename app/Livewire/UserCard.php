<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserCard extends Component
{
    public User $user;

    public bool $isFollowing = false;

    #[On('followUpdate')]
    public function refreshData()
    {
        $this->isFollowing = auth()->user()->isFollowing($this->user);
    }

    public function mount()
    {
        $this->refreshData();
    }

    public function handleUnfollow()
    {
        if (auth()->id() === $this->user->id) {
            return;
        }

        auth()->user()->unfollow($this->user);

        $this->dispatch('followUpdate', [
            'status' => 'success',
            'message' => "{$this->user->first_name} unfollowed successfully!"
        ]);
    }

    public function handleFollow()
    {
        if (auth()->id() === $this->user->id) {
            return;
        }

        auth()->user()->follow($this->user);

        $this->dispatch('followUpdate', [
            'status' => 'success',
            'message' => "{$this->user->first_name} followed successfully!"
        ]);
    }

    public function render()
    {
        return view('livewire.user-card');
    }
}
