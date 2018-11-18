<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 13.11.2018
 * Time: 14:42
 */

namespace App\ClassContainer\Authentication;


use App\Jobs\RegistrationEmailJob;
use App\LoginToken;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\ClassContainer\SessionManager;

class AuthenticatesUser {

    /**
     * Invites the user by : creating user, creating token for this user, sending invite email with token link
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(Request $request)
    {
        $user=$this->createUser($request);
        $this->createToken($user)
            ->sendRegistrationEmail();

        SessionManager::flashMessage(Lang::get('authentication.please_confirm'));

        return redirect()->route('login');
    }

    /**
     * Saves the credentials if remember-me is on , and creates uconfirmed user
     * @param $request
     * @return mixed
     */
    private function createUser($request)
    {
        if ($request->has('remember-me'))
        {
            SessionManager::rememberUser($request->only(['email', 'password']));
        }

        return User::Create($request->only(['name','email','password']));
    }

    /**
     * @param $user
     * @return mixed
     */
    private function createToken($user)
    {
        return LoginToken::generateFor($user);
    }

    /**
     * Authenticates user with the given token
     * @param LoginToken $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(LoginToken $token)
    {
        $user=$token->user;

        if ($user->firstAuthentication()){
            $message = Lang::get('authentication.confirmation',['name' => $user->name]);
        }
        else {$message = Lang::get('authentication.already_confirmed',['name' => $user->name]);};

        SessionManager::flashMessage($message);

        return redirect()->route('login');
    }

    public function login(Request $request)
    {

        $credentials=$request->only(['email','password']);

        if ($request->has('remember-me'))
        {
            SessionManager::rememberUser($credentials);
        }

        if (!Auth::attempt($credentials)) {
            SessionManager::flashMessage(Lang::get('authentication.credentials_check'));
            return redirect()->back();
        }
        return redirect()->intended('home');
    }

    public function logOut()
    {
        Auth::logout();
        return redirect()->route('out');
    }


}

