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
    public bool $uploading_error = false;

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
    public function refreshHeaderText($param)
    {
        $status = $param['status'];

        if ($status !== 'success') return;

        $this->username = auth()->user()->username;
        $this->name = auth()->user()->selectRaw('CONCAT(first_name, " ", last_name) as name')->first()->name;
    }

    public function render()
    {
        return auth()->user()->id === $this->user_id ?
            view('livewire.components.profile.header') :
            view('livewire.components.profile.header_guest');
    }
}
