<?php

namespace App\Http\Middleware;

use App\ClassContainer\SessionManager;
use Closure;
use Illuminate\Support\Facades\Lang;

class MustBeEmailVerified {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($user = $request->user())
//        {
//            if ($user && $user->isEmailVerified())
//            {
//                return $next($request);
//            }
//        }
//        SessionManager::flashMessage(Lang::get('authentication.email_confirmation'));
//
//        return route('out');
    }

}
