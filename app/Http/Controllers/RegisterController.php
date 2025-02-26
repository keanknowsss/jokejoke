<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create($request->all());
            Auth::login($user);

            DB::commit();
            return redirect('/');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
