<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 13.11.2018
 * Time: 14:42
 */

namespace App\ClassContainer\Authentication;


use App\LoginToken;
use App\ResetToken;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\ClassContainer\SessionManager;
use PHPUnit\Framework\Exception;

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
            $this->createLoginToken($user)
                ->sendRegistrationEmail();

            return redirect()->route('login')->with('message', Lang::get('authentication.please_confirm'));
        }

        return redirect()->back()->withErrors(Lang::get('authentication.credentials_check'));

    }

    /**
     * Authenticates user with the given Login token
     * @param LoginToken $token
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(LoginToken $token)
    {
        $user = $token->user;

        $message = ($user->firstAuthentication() ?
            Lang::get('authentication.confirmation', ['name' => $user->name]) :
            Lang::get('authentication.already_confirmed', ['name' => $user->name]));

        return redirect()->route('login')->with('message', $message);

    }

    /**
     * Attempts to Log in the user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function login()
    {
        $this->rememberUser();
            return $this->loginAttempt();
    }

    /**
     * Logs out the user
     * @return RedirectResponse
     */
    public function logOut()
    {
        Auth::logout();
        return redirect()->route('home')->with('message', Lang::get('authentication.log_out'));
    }


    /**
     * grabs the user with given email, for user creates new resetToken, sends the link on users email
     * @return $this|RedirectResponse
     * @throws \Exception
     */
    public function resetPassword()
    {
        $user = User::byEmail(request('email'));

        $this->createResetToken($user)
            ->sendResetEmail();

        return redirect()->route('login')->with('message', Lang::get('authentication.reset_password_message'));
    }

    /**
     * For the returned token, grabs the user for this token and generates the view with to user remember_token
     * @param ResetToken $token
     * @return $this
     */
    public function createNewPasswordForm(ResetToken $token)
    {

        $user = $token->user;

        return view("authentication.login.changePasswordForm", compact('user'));

    }


    public function changePassword($request)
    {

        $user = User::byEmail(request('email'));

        $user->changePassword($request);

        $this->rememberUser();

        return redirect()->route('login')->with('message', Lang::get('authentication.password_reset_successful'));

    }

    /**
     * Saves the credentials if remember-me is on , and creates uconfirmed user
     * @return mixed
     */
    private function createUser()
    {
        $this->rememberUser();
        $credentials=request()->only(['name', 'email', 'password']);
        $credentials['remember_token']=str_random(50);
        return User::create($credentials);
    }

    /**
     * @param $user
     * @return mixed
     */
    private function createLoginToken($user)
    {
        return LoginToken::generateFor($user);
    }

    /**
     * @param $user
     * @return mixed
     */
    private function createResetToken($user)
    {
        return ResetToken::generateFor($user);
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

