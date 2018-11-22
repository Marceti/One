<?php

namespace App\Http\Controllers\Authentication;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\LoginToken;
use Illuminate\Http\Request;

class RegistrationController extends Controller {

    /**
     * RegistrationController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('authentication.registration.registerForm');
    }

    /**
     * Stores User, and sends Token - link Email
     * @param AuthenticatesUser $auth
     * @param RegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(AuthenticatesUser $auth, RegistrationRequest $request)
    {
        return $auth->invite();
    }

    /**
     * Tries to validate user with the given token
     * @param AuthenticatesUser $auth
     * @param LoginToken $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(AuthenticatesUser $auth, LoginToken $token)
    {
        return $auth->authenticate($token);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resendTokenForm()
    {
        return view("authentication.registration.emailConfirmationForm");
    }

    /**
     * Resends the token to the user with the given email
     * @param AuthenticatesUser $auth
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resendToken(AuthenticatesUser $auth, Request $request)
    {
        $this->validate($request,[
            'email'=> 'required|email',
        ]);

        return $auth->invite(true);
    }


}
