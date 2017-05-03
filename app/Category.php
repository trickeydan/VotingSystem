<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];

    public function nominees(){
        return $this->hasMany('App\Nominee');
    }

    public function getVotableArray(){
        $array = [];
        foreach ($this->nominees as $nominee){
            $array[$nominee->user->id] = $nominee->user->name;
        }
        return $array;
    }
}
