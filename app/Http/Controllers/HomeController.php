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

    /**
     * Redirect the user to the appropiate page for the current mode.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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
