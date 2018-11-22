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
//TODO Fa ruta asta cu nume , si mailul sa trimita URL compus din route()->name

//This path is used in order to resend confirmation email
Route::get("/login/resend", '\App\Http\Controllers\Authentication\RegistrationController@resendTokenForm')->name('login_confirmation');
Route::post("/login/resend", '\App\Http\Controllers\Authentication\RegistrationController@resendToken');

Route::get("/login", '\App\Http\Controllers\Authentication\SessionsController@create')->name('login');
Route::post("/login", '\App\Http\Controllers\Authentication\SessionsController@store');
Route::get("/logout", '\App\Http\Controllers\Authentication\SessionsController@destroy')->name('logout');


//Reset password
Route::get("/login/resetPassword", '\App\Http\Controllers\Authentication\SessionsController@resetPasswordForm')->name('reset_password');
Route::post("/login/resetPassword", '\App\Http\Controllers\Authentication\SessionsController@resetPassword');

//TODO Fa ruta asta cu nume , si mailul sa trimita URL compus din route()->name
Route::get("/resetPassword/token/{token}", '\App\Http\Controllers\Authentication\SessionsController@CreateNewPassword');
Route::post("/resetPassword/token", '\App\Http\Controllers\Authentication\SessionsController@StoreNewPassword')->name('change_password');
/* ***  Regular  *** */

Route::get("/", '\App\Http\Controllers\HomeController@index')->name('home');

