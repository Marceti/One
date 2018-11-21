<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 21.11.2018
 * Time: 12:47
 */

namespace App\ClassContainer;


class RouterManager {

    public static function redirectToRouteName($routeName, $flashMessage = null)
    {

        if ($flashMessage) {

            $messages = (is_array($flashMessage) ? $flashMessage : []);
            $messages[] = (is_string($flashMessage) ? $flashMessage : null);
            SessionManager::flashMessages($messages);
        }
        return redirect()->route($routeName);
    }

    public static function redirectBack($flashMessage = null)
    {
        if ($flashMessage) {
            $messages = (is_array($flashMessage) ? $flashMessage : []);
            $messages[] = (is_string($flashMessage) ? $flashMessage : null);
            SessionManager::flashMessages($messages);
        }
        return redirect()->back();
    }
}