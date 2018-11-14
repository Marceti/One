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
use Illuminate\Http\Request;

class AuthenticatesUser {

    public function invite(Request $request)
    {
        $user=$this->createUser($request);
        $this->createToken($user)
            ->sendRegistrationEmail();
    }

    private function createUser($request)
    {
        return User::Create($request->only(['name','email','password']));
    }

    private function createToken($user)
    {
        return LoginToken::generateFor($user);
    }
}

