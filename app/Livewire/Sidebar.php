<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class Sidebar extends Component
{
    public $fullname;
    public $username;
    public $profile_pic;

    public function mount() {
        $user = auth()->user();

        if ($user) {
            $this->fullname = ucwords("$user->first_name $user->last_name");
            $this->username = "@$user->username";
            $this->profile_pic = auth()->user()->profile?->profile_pic_path ? Storage::url(auth()->user()->profile->profile_pic_path) : asset('assets/placeholders/user_avatar.png');
        }
    }

    #[On('profilePicUploaded')]
    public function updatedProfilePic()
    {
        $this->profile_pic = Storage::url($this->profile_pic = auth()->user()->profile->profile_pic_path);
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
