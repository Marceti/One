<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\ClassContainer\RouterManager;

class MustBeEmailVerified {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest())
        {
            if (! $request->ajax()){
                $user = (request()->has('email') ? User::byEmail(request('email')) : null);

                if ($user)
                {
                    if ($user->isEmailVerified())
                    {
                        return $next($request);
                    }

                    return redirect()->back()->withErrors(Lang::get('authentication.email_confirmation')) ;
                }

                return redirect()->back()->withErrors(Lang::get('authentication.credentials_check'));
            }

            return response('Unautorized.',401);
        }

        return redirect()->back()->withErrors(Lang::get('authentication.logged_in'));

    }

}
