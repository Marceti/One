@extends('layouts.master')

@section('content')


<div class="container py-5">
    <div class="row text-center" >
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4" >
            <h1 class="h3 mb-3 font-weight-normal">{{ Lang::get('authentication.change_password_header') }}</h1>

            <form method="POST" action="{{route('change_password')}}">

                {{csrf_field()}}

                <input type="hidden" name="remember_token" id="hiddenField" value={{$user->remember_token}} />
                <input type="hidden" name="reset_token" id="hiddenField" value={{$user->resetToken->token}} />

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Your Email Here" required
                           value={{$user->email}}>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Your Password Here" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Password confirmation:</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Retype Password Here" required>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" name="remember-me"> {{ Lang::get('authentication.remember_me') }}
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn btn-block">Change Password</button>
                </div>

            </form>


        </div>
        <div class="col-lg-4">
        </div>

    </div>
</div>
@endsection