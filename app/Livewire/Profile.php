<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app_lw')]
#[Title('Profile')]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.profile');
    }
}
