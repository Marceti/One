@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row text-center" >
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4" >
                <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>


                <form method="POST" action="/login">

                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Your Email Here" required value={{session('user_email')}}>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Your Password Here" required value={{session('user_password')}}>
                    </div>
                    <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn btn-block">Login</button>
                    </div>

                </form>


            </div>
            <div class="col-lg-4">
            </div>

        </div>
    </div>

@endsection