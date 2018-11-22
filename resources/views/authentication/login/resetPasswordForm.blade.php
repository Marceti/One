@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row text-center">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <h1 class="h3 mb-3 font-weight-normal">{{ Lang::get('authentication.reset_password_header') }}</h1>


                <form method="POST" action={{route('reset_password')}}>

                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Your Email Here" required
                               value={{session('user_email')}}>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn btn-block">{{ Lang::get('authentication.send_link_button') }}</button>
                    </div>

                </form>

            </div>
            <div class="col-lg-4">
            </div>

        </div>
    </div>

@endsection