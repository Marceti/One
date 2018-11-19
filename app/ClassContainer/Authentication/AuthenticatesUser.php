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


    private $authConditions = ['noExtraChecks', 'emailVerification'];
    // $authConditions [] =[ , , ]
    //                  noExtraChecks       :   no extra checks are necesary
    //                  emailVerification   :   the user must have the email verified
    //

    /**
     * Invites the user by : creating user, creating token for this user, sending invite email with token link
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(Request $request)
    {
        $user = $this->createUser($request);

        $this->createToken($user)
            ->sendRegistrationEmail();

        SessionManager::flashMessage(Lang::get('authentication.please_confirm'));

        return redirect()->route('login');
    }

    /**
     * Authenticates user with the given token
     * @param LoginToken $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(LoginToken $token)
    {
        $user = $token->user;

        if ($user->firstAuthentication())
        {
            $message = Lang::get('authentication.confirmation', ['name' => $user->name]);
        } else
        {
            $message = Lang::get('authentication.already_confirmed', ['name' => $user->name]);
        };

        SessionManager::flashMessage($message);

        return redirect()->route('login');
    }

    /**
     * Attempts to Log in the user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->rememberUser($request);

        return $this->loginAttempt($request);
    }

    /**
     * Logs out the user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOut()
    {
        Auth::logout();

        return redirect()->route('home');
    }


    /**
     * Saves the credentials if remember-me is on , and creates uconfirmed user
     * @param $request
     * @return mixed
     */
    private function createUser($request)
    {
        $this->rememberUser($request);

        return User::Create($request->only(['name', 'email', 'password']));
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
     * @param $request
     */
    private function rememberUser($request)
    {
        if ($request->has('remember-me'))
        {
            SessionManager::rememberUser($request->only(['email', 'password']));
        }
    }

    private function loginAttempt($request)
    {
        $user = User::byEmail($request->input('email'));

        if ($user && $this->loginConditions($user))
        {
            if (Auth::attempt($request->only(['email', 'password'])))
            {
                return redirect()->intended(request('home'));
            }
        };

        SessionManager::flashMessage(Lang::get('authentication.credentials_check'));

        return redirect()->route('login');
    }

    private function loginConditions(User $user)
    : bool
    {
        $conditionResult = true;

        foreach ($this->authConditions as $condition)
        {
            $conditionResult &= $this->loginCondition($user, $condition);
        }

        return $conditionResult;
    }

    private function loginCondition(User $user, $condition)
    : bool
    {
        switch ($condition)
        {
            case "noExtraChecks":
                return true;
                break;

            case "emailVerification":
                return $user->isEmailVerified();
                break;

            default:
                return false;
        }
    }


}

