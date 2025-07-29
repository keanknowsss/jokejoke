<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


#[Layout('layouts.app_lw')]
#[Title('Profile')]
class Profile extends Component
{

    public User $user;

    public function mount(int $user_id)
    {
        $user = User::find($user_id);

        if (!$user)
            return redirect('/');

        $this->user = $user;
    }

    // #[On('updatedAbout')]
    #[On('profilePicUploaded')]
    #[Computed()]
    public function profile()
    {
        $user_profile = User::leftjoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $this->user->id)
            ->select([
                DB::raw('CONCAT(first_name, " ", last_name) as name'),
                'first_name',
                'last_name',
                'username',
                'birthdate',
                'email',
                'bio',
                'users.created_at as date_joined',
                'profile_pic_path',
                'cover_pic_path'
                // followers and following
            ])
            ->first();

        return $user_profile;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
