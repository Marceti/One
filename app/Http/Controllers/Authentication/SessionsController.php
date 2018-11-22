<?php

namespace App\Http\Controllers\Authentication;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Requests\LoginRequest;
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
        return $auth->login();
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

    public function CreateNewPassword(AuthenticatesUser $auth, ResetToken $token)
    {
        return $auth->createNewPasswordForm($token);
    }

    public function StoreNewPassword(AuthenticatesUser $auth)
    {
        //TODO: 1 IMPORTANT : Formul trimite datele aici si trebuie sa continui
        //TODO: 2 Creaza un [ChangePasswordRequest $request] ca sa validezi inputul
        //TODO: 3 Apeleaza [$auth->changePassword()] care va verifica daca request('remember_token') coincide cu userul
        //TODO: 4 Daca inputul e valid , atunci modifica passwordul, si STERGE resetTokenul
        
        //return $auth->changePassword();
    }

    public function resetPasswordForm()
    {
        return view("authentication.login.resetPasswordForm");
    }

    public function resetPassword(AuthenticatesUser $auth,Request $request)
    {
        $this->validate($request,[
            'email'=> 'required|email',
        ]);

        return $auth->resetPassword();
    }
}
