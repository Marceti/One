<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
       // $this->middleware("must.be.verified");
        //TODO : am incercat sa pun un middleware prorpiu si a dat ceva eroare - incearca sa-l faci
    }

    public function index()
    {
        return view('welcomeOne');
    }
}
