<?php

namespace App\Http\Controllers\Authentication;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller {

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        return view("authentication.login.loginForm");
    }

    public function store(LoginRequest $request, AuthenticatesUser $auth)
    {
        return $auth->login($request);
    }

    public function destroy(AuthenticatesUser $auth)
    {
        return $auth->logOut();
    }

}
