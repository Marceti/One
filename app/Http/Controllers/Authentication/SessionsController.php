<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{

    public function create()
    {
        return view("authentication.login.loginForm");
    }

    public function store(LoginRequest $request)
    {
        
    }
}
