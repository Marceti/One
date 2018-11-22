<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 13.11.2018
 * Time: 14:42
 */

namespace App\ClassContainer\Authentication;


use App\LoginToken;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\ClassContainer\SessionManager;

class AuthenticatesUser {


    /**
     * Invites the user by : creating user or grabing user, creating token for this user, sending invite email with token link
     * @param bool $existing
     * @return RedirectResponse
     * @throws \Exception
     */
    public function invite($existing = false)
    {
        $user = (! $existing ? $this->createUser() : User::byEmail(request('email')));

        if ($user)
        {
            $this->createToken($user)
                ->sendRegistrationEmail();

            return redirect()->route('login')->with('message',Lang::get('authentication.please_confirm'));
        }

        return redirect()->back()->withErrors(Lang::get('authentication.credentials_check'));

    }

    /**
     * Authenticates user with the given token
     * @param LoginToken $token
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(LoginToken $token)
    {
        $user = $token->user;

        $message = ($user->firstAuthentication() ?
            Lang::get('authentication.confirmation', ['name' => $user->name]) :
            Lang::get('authentication.already_confirmed', ['name' => $user->name]));

        return redirect()->route('login')->with('message',$message);

    }

    /**
     * Attempts to Log in the user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function login()
    {
        $this->rememberUser();

        $user = (request()->has('email') ? User::byEmail(request('email')):null);

        if ($user)      {return $this->loginAttempt();}
        else            {return redirect()->back()->withErrors(Lang::get('authentication.credentials_check'));}

    }

    /**
     * Logs out the user
     * @return RedirectResponse
     */
    public function logOut()
    {
        Auth::logout();

        return redirect()->route('home');
    }


    /**
     * Saves the credentials if remember-me is on , and creates uconfirmed user
     * @return mixed
     */
    private function createUser()
    {
        $this->rememberUser();

        return User::create(request()->only(['name', 'email', 'password']));
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
     * If checkbox , remembers the user in current session
     */
    private function rememberUser()
    {
        if (request()->has('remember-me'))
        {
            SessionManager::rememberUser(request()->only(['email', 'password']));
        }
    }


    /**
     * Attempts to login the user if the extra-conditions pass and also user-password matches
     * @return RedirectResponse
     */
    private function loginAttempt()
    {
        if (Auth::attempt(request()->only(['email', 'password'])))
        {
            return redirect()->intended(request('home'));
        }

        return redirect()->route('login')->withErrors(Lang::get('authentication.wrong_password'));
    }

}

