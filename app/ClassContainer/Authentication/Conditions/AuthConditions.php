<?php
/**
 * Created by PhpStorm.
 * User: marce
 * Date: 20.11.2018
 * Time: 12:09
 */

namespace App\ClassContainer\Authentication\Conditions;


class AuthConditions {

    protected $conditions=[];

    public function getConditions()
    {
        return $this->conditions;
    }


    /**
     *Adds the condition of Email shoul be verified, as instance of the class in array
     */
    public function addEmailVerified()
    {
        $this->conditions[]=AcEmailVerified::class;
    }

    //You can add as many rules or conditions you want
}