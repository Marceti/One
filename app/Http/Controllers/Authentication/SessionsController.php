<?php

namespace App\Http\Controllers\Authentication;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\ResetToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller {

    public function __construct()
    {
        $this->middleware('guest')-> except('destroy');
        $this->middleware('email_verified')->only("store");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view("authentication.login.loginForm");
    }

    /**
     * If all the conditions are true (see middleware), attempts to login the user
     * @param LoginRequest $request
     * @param AuthenticatesUser $auth
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(LoginRequest $request, AuthenticatesUser $auth)
    {
        return $auth->login($request);
    }

    /**
     * Loggs out the user
     * @param AuthenticatesUser $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AuthenticatesUser $auth)
    {
        return $auth->logOut();
    }


    /**
     * Generates the view for the new password
     * @param AuthenticatesUser $auth
     * @param ResetToken $token
     * @return AuthenticatesUser
     */
    public function CreateNewPassword(AuthenticatesUser $auth, ResetToken $token)
    {
        return $auth->createNewPasswordForm($token);
    }

    /**
     * @param AuthenticatesUser $auth
     * @return
     */
    public function StoreNewPassword(ResetPasswordRequest $request, AuthenticatesUser $auth)
    {
        return $auth->changePassword($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPasswordForm()
    {
        return view("authentication.login.resetPasswordForm");
    }

    /**
     * @param AuthenticatesUser $auth
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(AuthenticatesUser $auth, Request $request)
    {
        $this->validate($request,[
            'email'=> 'required|email|exists:users,email',
        ]);

        return $auth->resetPassword();
    }
}
