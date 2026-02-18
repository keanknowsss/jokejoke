<?php

namespace App\Livewire\Components\Profile;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Header extends Component
{
    use WithFileUploads;

    public int $user_id;

    public User $user;

    public string $profile_photo_link;
    public string $cover_photo_link;

    #[Rule(['required', 'image', 'max:5120'])]
    public $cover_photo;

    #[Rule(['required', 'image', 'max:5120'])]
    public $profile_photo;
    public bool $uploading_error = false;

    public function mount(
        int $user_id,
    ) {
        $this->user = User::with(['profile', 'summary'])->find($user_id);
    }

    public function uploadCoverPic()
    {
        $this->validateOnly('cover_photo');
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $cover_pic_path = $this->cover_photo->store("uploads/user/{$user->id}", 'public');

            $user->profile->update([
                'cover_pic_path' => $cover_pic_path
            ]);

            DB::commit();

            $this->cover_photo_link = Storage::url($cover_pic_path);

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

    public function updatedProfilePhoto() {
        try {
            $this->validateOnly('profile_photo');
            $this->uploading_error = false;
        } catch (\Throwable $th) {
            $this->uploading_error = true;
        }
    }
    public function updatedCoverPhoto() {
        try {
            $this->validateOnly('cover_photo');
            $this->uploading_error = false;
        } catch (\Throwable $th) {
            $this->uploading_error = true;
        }
    }

    public function uploadProfilePic()
    {
        $this->validateOnly('profile_photo');

        $user = auth()->user();

        DB::beginTransaction();

        try {
            $profile_pic_path = $this->profile_photo->store("uploads/user/{$user->id}", 'public');

            $user->profile->update([
                'profile_pic_path' => $profile_pic_path
            ]);

            DB::commit();

            $this->profile_photo_link = Storage::url($profile_pic_path);

            $this->dispatch('profilePicUploaded', [
                'status' => 'success',
                'message' => 'Profile photo successfully updated'
            ]);
        } catch (\Throwable $th) {
            \Log($th->getMessage());
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

    #[On('updatedAbout')]
    public function refreshUserData()
    {
        $this->user->refresh();
        $this->user->load('profile');
    }

    public function render()
    {
        return auth()->user()->id === $this->user_id ?
            view('livewire.components.profile.header') :
            view('livewire.components.profile.header_guest');
    }
}
