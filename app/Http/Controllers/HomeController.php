<?php

namespace App\Http\Controllers;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('cors');
    }
    public function get_root(){
        //return 'Welcome To Saia';
        return view('home', ['app_name' => 'Saia | Exim']);
    }
    public function test(){
       
    }
    //
}
