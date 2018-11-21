<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 13.11.2018
 * Time: 14:42
 */

namespace App\ClassContainer\Authentication;

use App\ClassContainer\Authentication\Conditions\AuthConditions;
use App\ClassContainer\Authentication\Conditions\AuthConditionsHandler;
use App\LoginToken;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\ClassContainer\SessionManager;

class AuthenticatesUser {

    /**
     * Extra conditions that a user should satisfy in order to be logged in
     * @return AuthConditions
     */
    public function loginConditions()
    {
        $conditions = new AuthConditions();
        // *************** Here you can add as many conditions as you want **************

        $conditions->addEmailVerified();

        //*******************************************************************************

        return $conditions;
    }

    /**
     * Invites the user by : creating user, creating token for this user, sending invite email with token link
     * @param bool $existing
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function invite($existing = false)
    {
        //TODO: Aici aven doua conditii , daca existing = false : facem user nou, daca = true, incercam sa gasim userul, dar daca nu-l gasim : automat este 404 , si ar trebui sa prin exceptia
        try {$user = ( ! $existing ? $this->createUser() : User::byEmail(request('email')));}
        catch (\Exception $e){
            dd($e);
        };


        $this->createToken($user)
            ->sendRegistrationEmail();

        SessionManager::flashMessage(Lang::get('authentication.please_confirm'));

        return redirect()->route('login');

        SessionManager::flashMessage(Lang::get('authentication.credentials_check'));

        return redirect()->back();
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        $this->rememberUser();

        return $this->loginAttempt($this->loginConditions());
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
     * @return mixed
     */
    private function createUser()
    {
        $this->rememberUser();

        return User::Create(request()->only(['name', 'email', 'password']));
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
        if ($request->has('remember-me'))
        {
            SessionManager::rememberUser(request()->only(['email', 'password']));
        }
    }


    /**
     * Attempts to login the user if the extra-conditions pass and also user-password matches
     * @param AuthConditions $conditions
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginAttempt(AuthConditions $conditions)
    {

        try
        { $user = User::byEmail(request()('email'));
        } catch (\Exception $e)
        {
            SessionManager::flashMessage(Lang::get('authentication.credentials_check'));
            return redirect()->back();
        }

        if (AuthConditionsHandler::handle($user, $conditions))
        {
            if (Auth::attempt(request()->only(['email', 'password'])))
            {
                return redirect()->intended(request('home'));
            }
        };

        SessionManager::flashMessages($this->collectMessages($user, $conditions));

        return redirect()->route('login');
    }


    /**
     * Extracts messages from unpassed conditions if exist, if not returns general message
     * @param User $user
     * @param AuthConditions $conditions
     * @return array
     */
    private function collectMessages(User $user, AuthConditions $conditions)
    {

        if (count($messages = AuthConditionsHandler::getMessages($user, $conditions)) < 1)
        {
            $messages[] = Lang::get('authentication.credentials_check');
        };

        return $messages;
    }

    private function redirectToRouteName($routeName, $flashMessage = null)
    {
        if ($flashMessage) {SessionManager::flashMessages($flashMessage);}

        return redirect()->route('$routeName');
    }


}

