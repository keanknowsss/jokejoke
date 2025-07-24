<?php

namespace App\Livewire\Components\Profile;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Header extends Component
{
    use WithFileUploads;

    public int $user_id;
    public string $username;

    public string $name;

    public string $profile_photo_link;
    public bool $has_profile_pic;
    public string $cover_photo_link;
    public bool $has_cover_pic;

    #[Rule(['required', 'image', 'max:5120'])]
    public $cover_photo;

    #[Rule(['required', 'image', 'max:5120'])]
    public $profile_photo;

    public function mount(
        int $user_id,
        string $username,
        string $name,
        string|null $profile_pic,
        string|null $cover_pic
    ) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->name = $name;

        $this->profile_photo_link = $profile_pic ? Storage::url($profile_pic) : asset('assets/placeholders/user_avatar.png');
        $this->has_profile_pic = $profile_pic ? true : false;

        $this->cover_photo_link = $cover_pic ? Storage::url($cover_pic) : asset('assets/placeholders/user_cover.jpg');
        $this->has_cover_pic = $cover_pic ? true : false;
    }


    public function fetchUserData()
    {
        $this->username = auth()->user()->username;
        $this->name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    }

    public function uploadCoverPic()
    {
        $this->validateOnly('cover_photo');
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->profile->update([
                'cover_pic_path' => $this->cover_photo->store("uploads/user/{$user->id}", 'public')
            ]);

            DB::commit();

            $this->dispatch('coverUploaded', [
                'status' => 'success',
                'message' => 'Cover photo successfully updated'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('coverUploaded', [
                'status' => 'error',
                'type' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ]);
        }

        $this->reset('cover_photo');
    }

    public function uploadProfilePic()
    {
        $this->validateOnly('profile_photo');

        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user->profile->update([
                'profile_pic_path' => $this->profile_photo->store("uploads/user/{$user->id}", 'public')
            ]);

            DB::commit();

            $this->dispatch('profilePicUploaded', [
                'status' => 'success',
                'message' => 'Profile photo successfully updated'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('profilePicUploaded', [
                'status' => 'error',
                'type' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ]);
        }

        $this->reset('profile_photo');
    }

    public function resetProfilePic() {
        $this->resetValidation(['profile_photo']);
        $this->reset('profile_photo');
    }

    public function resetCoverPic() {
        $this->resetValidation(['cover_photo']);
        $this->reset('cover_photo');
    }

    public function render()
    {
        return auth()->user()->id === $this->user_id ?
            view('livewire.components.profile.header') :
            view('livewire.components.profile.header_guest');
    }
}
