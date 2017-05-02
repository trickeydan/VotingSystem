<?php

namespace App;

use Illuminate\Support\Facades\Auth;

abstract class System
{
    const MODE_NOMINATE = 'Nominations';
    const MODE_VOTE = 'Voting';
    const MODE_NONE = 'None';

    /**
     * Get the current system mode.
     *
     * @return string
     */
    public static function mode(){
        return self::MODE_NOMINATE;
    }

    public static function getNominatable(){
        $user = Auth::User();
        return User::where('id','!=',$user->id)->orderBy('name')->get();
    }

    public static function getNominatableArray(){
        $array = [];
        foreach (self::getNominatable() as $user){
            $array[$user->id] = $user->name;
        }
        return $array;
    }
}