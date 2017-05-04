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
        }elseif(System::mode() == System::MODE_VOTE) {
            return redirect(route('vote'));
        }else{
            return redirect(route('home'));
        }

    }
}
