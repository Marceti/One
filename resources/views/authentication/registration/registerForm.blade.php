@extends('layouts.master')

@section('content')

@endsection

<div class="container py-5">
    <div class="row text-center" >
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4" >
            <h1 class="h3 mb-3 font-weight-normal">Registration</h1>

            <form method="POST" action="{{route('register')}}">

                {{csrf_field()}}



                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" placeholder="Your Name Here" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Your Email Here" required>
                </div>


                <div class="form-group">
                    <label for="password">Password:</label>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Your Password Here" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Password confirmation:</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Retype Password Here" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn btn-block">Register</button>
                </div>


                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" name="remember-me"> Remember me
                    </label>
                </div>

            </form>



        </div>
        <div class="col-lg-4">
        </div>

    </div>
</div>
