<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout('layouts.app_lw')]
#[Title('Profile')]
class Profile extends Component
{
    public User $user;

    public string $displayed_section = 'jokes';


    public function mount(int $user_id)
    {
        $user = User::with('profile')->find($user_id);

        if (!$user)
            return redirect('/');

        if (!$user->profile) {
            $this->displayed_section = 'about';
        }

        $this->user = $user;

        $this->has_profile = (bool) $user->profile;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
