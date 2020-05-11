<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function update(User $user, UserUpdateRequest $request)
    {
        $request->updateUser($user);
    }
}
