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
        string $username,
        string $first_name,
        string $last_name,
        string $email,
        string|null $birthdate,
        string|null $bio,
        string $date_joined
    ) {
        $this->user_id = $user_id;

        $this->original_values = [
            'username' => $username,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'birthdate' => $birthdate,
            'bio' => $bio
        ];
        $this->username = $this->original_values['username'];

        $this->date_joined = Carbon::parse($date_joined)->format('F j, Y');

        $this->first_name = $this->original_values['first_name'];
        $this->last_name = $this->original_values['last_name'];

        $this->email = $this->original_values['email'];
        $this->birthdate = $this->original_values['birthdate'];

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


        try {
            DB::beginTransaction();

            auth()->user()->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'username' => $this->username,
            ]);

            auth()->user()->profile->update([
                'birthdate' => $this->birthdate,
                'bio' => $this->bio,
            ]);


            DB::commit();


            $this->original_values = [
                'username' => $this->username,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'birthdate' => $this->birthdate,
                'bio' => $this->bio
            ];

            $this->dispatch('updatedAbout', [
                'status' => 'success',
                'message' => 'User Information successfully saved!'
            ]);
        } catch (\Throwable $th) {
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
