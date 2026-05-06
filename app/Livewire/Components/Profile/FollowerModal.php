<?php

namespace App\Livewire\Components\Profile;

use Livewire\Attributes\On;
use Livewire\Component;

class FollowerModal extends Component
{
    public int $count = 0;

    public $followers = [];

    #[On('followUpdate')]
    public function refreshData ()
    {
        $this->followers = auth()->user()->followers()->get();
        $this->count = auth()->user()->summary?->follower_count ?? 0;
    }

    public function mount()
    {
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.components.profile.follower-modal');
    }
}
