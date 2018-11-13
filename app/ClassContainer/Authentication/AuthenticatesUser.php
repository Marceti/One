<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 13.11.2018
 * Time: 14:42
 */

namespace App\ClassContainer\Authentication;


use App\Jobs\RegistrationEmailJob;
use App\User;
use Illuminate\Http\Request;

class AuthenticatesUser {

    public function invite($credentials)
    {
        $token =  $this->createToken();

        $user=User::AddUnconfirmed($credentials+=['remember_token'=>$token]);

        $this->sendRegistrationEmailFor($user);
    }


    private function createToken()
    {
        return str_random(50);
    }

    private function sendRegistrationEmailFor($user)
    {
        $registrationEmail = new RegistrationEmailJob($user);
        $registrationEmail->dispatch($user);
    }
}