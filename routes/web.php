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

Route::get('/', 'HomeController@index')->name('home');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth','notadmin']],function(){
    Route::get('/action','HomeController@action');

    Route::get('nominate','NominateController@nominate')->middleware('nominate')->name('nominate');
    Route::post('nominate','NominateController@nominatePost')->middleware('nominate')->name('nominate');
});


