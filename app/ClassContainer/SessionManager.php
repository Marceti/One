<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 15.11.2018
 * Time: 13:59
 */

namespace App\ClassContainer;


class sessionManager {

    public static function addMessage($message)
    {
        session(['message'=>$message]);

    }

    public static function flashMessage($message)
    {
        session()->flash('message',$message);
    }


}