<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = ['admin' => 'boolean'];

    /**
     * Get the next category that this user hasn't nominated anyone for.
     *
     * @return Category|bool
     */
    public function getNominationCategory(){
        //Todo: Make more efficient.
        foreach (Category::all() as $cat){
            if(Nomination::whereCategoryId($cat->id)->whereUserId($this->id)->count() == 0) return $cat;
        }
        return false;
    }

    /**
     * Get the next category that this user hasn't voted anyone for.
     *
     * @return Category|bool
     */
    public function getVoteCategory(){
        //Todo: Make more efficient.
        foreach (Category::all() as $cat){
            if(Vote::whereCategoryId($cat->id)->whereUserId($this->id)->count() == 0) return $cat;
        }
        return false;
    }
}
