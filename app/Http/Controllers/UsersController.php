<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
