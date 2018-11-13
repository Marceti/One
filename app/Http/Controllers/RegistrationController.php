<?php

namespace App\Http\Controllers;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    public function create()
    {
        return view('authentication.registration.registerForm');
    }

    public function store(AuthenticatesUser $auth, RegistrationRequest $request)
    {
        //request has been validated by RegistrationRequest
      $auth->invite($request->only(['name','email','password']));
    }
}
