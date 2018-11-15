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
     * @param $request
     * @return mixed
     */
    private function createUser($request)
    {
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
}

