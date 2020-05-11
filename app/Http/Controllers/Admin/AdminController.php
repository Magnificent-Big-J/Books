<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\User;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function register(UserCreateRequest $request)
    {
        $request->createUser();
    }
}
