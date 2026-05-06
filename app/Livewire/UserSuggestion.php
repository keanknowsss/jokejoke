<?php

namespace App\Livewire;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class UserSuggestion extends Component
{
    public Collection $users;


    #[On('followUpdate')]
    public function refreshSuggestions()
    {
        $following = auth()->user()->following()->get()
            ->pluck('follower_id')
            ->toArray();

        $this->users = User::whereNot('id', auth()->id())
            ->whereNotIn('id', $following)
            ->limit(5)
            ->inRandomOrder()
            ->get();
    }

    public function mount()
    {
        $this->refreshSuggestions();
    }

    public function render()
    {
        return view('livewire.user-suggestion');
    }
}
