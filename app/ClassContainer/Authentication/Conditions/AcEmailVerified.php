<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 20.11.2018
 * Time: 09:30
 */

namespace App\ClassContainer\Authentication\Conditions;
use App\User;
use Illuminate\Support\Facades\Lang;

class AcEmailVerified implements AuthCondition {

    public static function handle(User $user)
    {
        return $user->isEmailVerified();
    }

    public static function message(User $user)
    {
        return Lang::get('authentication.email_confirmation');
    }
}