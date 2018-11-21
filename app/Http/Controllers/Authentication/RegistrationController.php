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
        return $auth->invite();
    }

    public function authenticate(AuthenticatesUser $auth, LoginToken $token)
    {
        return $auth->authenticate($token);
    }

    public function createResendToken()
    {
        return view("authentication.registration.emailConfirmationForm");
    }

    public function resendToken(AuthenticatesUser $auth,Request $request)
    {
        $this->validate($request,[
            'email'=> 'required|email',
        ]);

        return $auth->invite(true);
    }

}
