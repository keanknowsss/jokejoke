<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $fullname;
    public $username;

    public function mount() {
        $user = auth()->user();

        if ($user) {
            $this->fullname = ucwords("$user->first_name $user->last_name");
            $this->username = "@$user->username";
        }

    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
