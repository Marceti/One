<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 15.11.2018
 * Time: 13:59
 */

namespace App\ClassContainer;


class SessionManager {

    public static function addKey($key, $message)
    {
        session([$key => $message]);

    }

    public static function flashMessage($message)
    {
        $messages = session('message');
        if ($message) {$messages[] = $message;};

        session()->flash('message', $messages);

    }

    public static function flashMessages(array $messages)
    {
        foreach ($messages as $message){
            static::flashMessage($message);
        }
    }

    public static function rememberUser($credentials)
    {
        static::addKey("user_email", $credentials['email']);
        static::addKey("user_password", $credentials['password']);
    }


}