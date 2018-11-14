<?php

namespace App\Http\Controllers\Authentication;

use App\ClassContainer\Authentication\AuthenticatesUser;
use App\Http\Controllers\Controller;
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
        $auth->invite($request);
    }
}
