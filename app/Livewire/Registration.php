<?php

namespace App\Livewire;

use App\Models\UserSummary;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app_lw')]
#[Title('Create an Account')]
class Registration extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';


    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'unique:users,username'],
            'password' => ['required', Password::min(6)]
        ];
    }

    public function handleRegister()
    {
        $validated = $this->validate();

        DB::beginTransaction();

        try {
            $user = User::create($validated);
            UserSummary::create([
                'user_id' => $user->id
            ]);

            Auth::login($user);


            DB::commit();
            return redirect('/');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.registration');
    }
}
