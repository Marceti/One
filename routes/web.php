<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


/* ***  Authentication  *** */

Route::get("/register", '\App\Http\Controllers\Authentication\RegistrationController@create')->name('register');
Route::post("/register", '\App\Http\Controllers\Authentication\RegistrationController@store');
Route::get("/register/token/{token}", '\App\Http\Controllers\Authentication\RegistrationController@authenticate');

Route::get("/login", '\App\Http\Controllers\Authentication\SessionsController@create')->name('login');
Route::post("/login", '\App\Http\Controllers\Authentication\SessionsController@store');
Route::get("/logout", '\App\Http\Controllers\Authentication\SessionsController@destroy')->name('logout');

//This path is used in order to resend confirmation email
Route::get("/login/resend", '\App\Http\Controllers\Authentication\RegistrationController@createResendToken')->name('login_confirmation');
Route::post("/login/resend", '\App\Http\Controllers\Authentication\RegistrationController@resendToken');

/* ***  Regular  *** */

Route::get("/", '\App\Http\Controllers\HomeController@index')->name('home');

