<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

abstract class System
{
    const MODE_NOMINATE = 1;
    const MODE_VOTE = 2;
    const MODE_FINISH = 3;

    /**
     * Get the current system mode.
     *
     * @return string
     */
    public static function mode(){
        return config('app.mode');
    }

    /**
     * Get a list of nominatable users
     *
     * @return Collection
     */
    public static function getNominatable(){
        $user = Auth::User();
        return User::where('id','!=',$user->id)->whereAdmin(false)->orderBy('name')->get();
    }

    /**
     * Get an array of nominatable users.
     *
     * @return array
     */
    public static function getNominatableArray(){
        $array = [];
        foreach (self::getNominatable() as $user){
            $array[$user->id] = $user->name;
        }
        return $array;
    }
}