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
    public string $username = '';

    public string $first_name = '';

    public string $last_name = '';

    public string $date_joined = '';

    public string $birthdate = '';

    public string $email = '';

    public string $bio = '';
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

    public function mount()
    {
        $this->loadUserData();
    }

    public function update()
    {
        $this->validate();

        // Check if at least one field is changed
        $modified = collect($this->original_values)->filter(fn($value, $key) => $this->$key !== $value);

        if ($modified->isEmpty()) {
            return $this->dispatch('updated', [
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

            $this->loadUserData();

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

    public function loadUserData()
    {
        $user = auth()->user()->refresh();

        $this->original_values = [
            'username' => $user->username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'birthdate' => $user->profile->birthdate,
            'bio' => $user->profile->bio ?? ""
        ];

        $this->username = $this->original_values['username'];

        $this->date_joined = Carbon::parse(auth()->user()->created_at)->format('F j, Y');

        $this->first_name = $this->original_values['first_name'];
        $this->last_name = $this->original_values['last_name'];

        $this->email = $this->original_values['email'];
        $this->birthdate = $this->original_values['birthdate'];

        $this->bio = $this->original_values['bio'];
    }

    public function render()
    {
        return view('livewire.components.profile.about');
    }
}
