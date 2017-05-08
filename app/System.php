<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

abstract class System
{
    const MODE_NONE = 0;
    const MODE_NOMINATE = 1;
    const MODE_VOTE = 2;
    const MODE_FINISH = 3;

    /**
     * Get the current system mode.
     *
     * @return string
     */
    public static function mode(){
        $setmode = config('app.mode');
        if($setmode == self::MODE_NOMINATE && self::getNominationDeadline()->isPast()) return self::MODE_NONE;
        if($setmode == self::MODE_VOTE && self::getVoteDeadline()->isPast()) return self::MODE_NONE;
        return $setmode;
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

    /**
     * Get the nomination deadline in a user readable format
     *
     * @return string
     */
    public static function getNominationDeadlineHuman(){
        return self::getNominationDeadline()->toDayDateTimeString();
    }

    /**
     * Get the nomination deadline
     *
     * @return Carbon
     */
    public static function getNominationDeadline(){
        return Carbon::createFromTimestampUTC(config('app.nomination_deadline'));
    }

    /**
     * Get the vote deadline in a user readable format
     *
     * @return string
     */
    public static function getVoteDeadlineHuman(){
        return self::getVoteDeadline()->toDayDateTimeString();
    }

    /**
     * Get the voting deadline
     *
     * @return Carbon
     */
    public static function getVoteDeadline(){
        return Carbon::createFromTimestampUTC(config('app.vote_deadline'));
    }

    public static function getNominationTurnoutPercent(){
        $votes = Nomination::all()->count();
        $catcount = Category::all()->count();
        $usercount = User::whereAdmin(false)->count();
        return round(($votes * 100) / ($catcount * $usercount),1);
    }


    public static function getVoteTurnoutPercent(){
        $votes = Vote::all()->count();
        $catcount = Category::all()->count();
        $usercount = User::whereAdmin(false)->count();
        return round(($votes * 100) / ($catcount * $usercount),1);
    }
}