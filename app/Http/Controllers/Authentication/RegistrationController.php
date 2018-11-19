<?php

namespace App\Http\Controllers\Authentication;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\LoginToken;
use Illuminate\Http\Request;

class RegistrationController extends Controller {

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        return view('authentication.registration.registerForm');
    }

    public function store(AuthenticatesUser $auth, RegistrationRequest $request)
    {
        return $auth->invite($request);
    }

    public function authenticate(AuthenticatesUser $auth, LoginToken $token)
    {
        return $auth->authenticate($token);
    }
}
