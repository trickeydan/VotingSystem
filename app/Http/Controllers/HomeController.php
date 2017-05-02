<?php

namespace App\Http\Controllers;

use App\System;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function action(){
        if(System::mode() == System::MODE_NOMINATE){
            return redirect(route('nominate'));
        }else{
            return redirect(route('home'));
        }
    }
}
