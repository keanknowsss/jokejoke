<?php

namespace App\Livewire\Components\Profile;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class About extends Component
{
    public int $user_id;

    public User $user;

    public string $username = '';

    public string $first_name = '';

    public string $last_name = '';

    public string $date_joined = '';

    public ?string $birthdate = '';

    public string $email = '';

    public ?string $bio = '';

    public array $original_values = [];

    public function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore(auth()->id())
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'email'],
            'bio' => ['nullable', 'string']
        ];
    }

    public function mount(
        int $user_id,
    ) {
        $this->user = User::with('profile')->find($user_id);

        $this->user_id = $user_id;

        $this->original_values = [
            'username' => $this->user->username,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'birthdate' => $this->user->profile?->birthdate,
            'bio' => $this->user->profile?->bio
        ];

        $this->first_name = $this->original_values['first_name'];
        $this->last_name = $this->original_values['last_name'];

        $this->username = $this->original_values['username'];
        $this->email = $this->original_values['email'];
        $this->birthdate = $this->original_values['birthdate'];

        $this->date_joined = Carbon::parse($this->user->created_at)->format('F j, Y');

        $this->bio = $this->original_values['bio'];
    }

    public function update()
    {
        $this->validate();

        // Check if at least one field is changed
        $modified = collect($this->original_values)->filter(fn($value, $key) => $this->$key !== $value);

        if ($modified->isEmpty()) {
            return $this->dispatch('updatedAbout', [
                'status' => 'empty',
                'message' => 'No information were modified.'
            ]);
        }

        DB::beginTransaction();

        try {

            auth()->user()->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'username' => $this->username,
            ]);

            if (!$this->has_profile) {
                Profile::create([
                    'user_id' => auth()->id(),
                    'birthdate' => $this->birthdate,
                    'bio' => $this->bio,
                ]);
            } else {
                auth()->user()->profile->update([
                    'birthdate' => $this->birthdate,
                    'bio' => $this->bio,
                ]);
            }

            DB::commit();

            $this->original_values = [
                'username' => $this->username,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'birthdate' => $this->birthdate,
                'bio' => $this->bio
            ];

            $this->user->refresh();
            $this->user->load('profile');

            $this->dispatch('updatedAbout', [
                'status' => 'success',
                'message' => 'User Information successfully saved!'
            ]);
        } catch (\Throwable $th) {
            \Log::error($th);
            DB::rollBack();

            $this->dispatch('updatedAbout', [
                'status' => 'error',
                'message' => 'Update failed. Something went wrong.'
            ]);
        }
    }


    public function render()
    {
        return auth()->user()->id === $this->user_id ?
            view('livewire.components.profile.about') :
            view('livewire.components.profile.about_guest');
    }
}
