<?php

namespace App\Livewire\Components\Profile;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Header extends Component
{
    use WithFileUploads;

    #[Rule(['required', 'image', 'max:5120'])]
    public $cover_photo;

    #[Rule(['required', 'image', 'max:5120'])]
    public $profile_photo;

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
                'message' => 'Cover photo successfully updated'
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

    public function render()
    {
        return view('livewire.components.profile.header');
    }
}
