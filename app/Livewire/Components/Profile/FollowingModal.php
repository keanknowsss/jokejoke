<?php

namespace App\Livewire\Components\Profile;

use Livewire\Attributes\On;
use Livewire\Component;

class FollowingModal extends Component
{
    public int $count = 0;

    public $following = [];

    #[On('followUpdate')]
    public function refreshData()
    {
        $this->following = auth()->user()->following()->orderBy('id')->get();
        $this->count = auth()->user()->summary?->following_count ?? 0;
    }

    public function mount()
    {
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.components.profile.following-modal');
    }
}
