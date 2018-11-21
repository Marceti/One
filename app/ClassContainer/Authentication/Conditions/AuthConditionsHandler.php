<?php


namespace App\ClassContainer\Authentication\Conditions;

use App\ClassContainer\SessionManager;
use App\User;

Class AuthConditionsHandler {

    public static function handle(User $user , AuthConditions $conditions)
    {

        $result = true;

        foreach ($conditions->getConditions() as $condition){

            $result = $result && $condition::handle($user);

        }

        return $result;

    }

    public static function getMessages(User $user , AuthConditions $conditions)
    {

        $message = [];

        if ($user){
            foreach ($conditions->getConditions() as $condition){

                if (!(true && $condition::handle($user))){

                    $message[]=$condition::message($user);
                }

            }

        }

        return $message;

    }


}