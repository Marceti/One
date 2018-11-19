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


/* ***  Authentication  *** */

Route::get("/register", '\App\Http\Controllers\Authentication\RegistrationController@create')->name('register');
Route::post("/register", '\App\Http\Controllers\Authentication\RegistrationController@store');
Route::get("/register/token/{token}", '\App\Http\Controllers\Authentication\RegistrationController@authenticate');

Route::get("/login", '\App\Http\Controllers\Authentication\SessionsController@create')->name('login');
Route::post("/login", '\App\Http\Controllers\Authentication\SessionsController@store');
Route::get("/logout", '\App\Http\Controllers\Authentication\SessionsController@destroy')->name('logout');

/* ***  Regular  *** */

Route::get("/", '\App\Http\Controllers\HomeController@index')->name('home');