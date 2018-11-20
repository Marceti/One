<?php


namespace App\ClassContainer\Authentication\Conditions;

use App\User;

interface AuthCondition {
    public static function handle(User $user);

    public static function message(User $user);
}