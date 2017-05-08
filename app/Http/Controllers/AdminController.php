<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * View the administrator control panel
     *
     * @return \Illuminate\View\View
     */
    public function admin(){
        return view('admin.home');
    }
}
