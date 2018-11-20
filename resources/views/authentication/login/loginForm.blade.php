@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row text-center">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <h1 class="h3 mb-3 font-weight-normal">{{ Lang::get('authentication.please_login_header') }}</h1>


                <form method="POST" action={{route('login')}}>

                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Your Email Here" required
                               value={{session('user_email')}}>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Your Password Here"
                               required value={{session('user_password')}}>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn btn-block">Login</button>
                    </div>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" name="remember-me"> Remember me
                        </label>
                    </div>

                </form>

                <p>
                    {{ Lang::get('authentication.resend_link.message_1') }}
                    <a href="{{URL::route('login_confirmation')}}">{{ Lang::get('authentication.resend_link.message_2') }}</a>
                    {{ Lang::get('authentication.resend_link.message_3') }}
                </p>

            </div>
            <div class="col-lg-4">
            </div>

        </div>
    </div>

@endsection