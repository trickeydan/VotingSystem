<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    protected $fillable = ['user_id','nominee_id','category_id'];
    /**
     * Get the user that did this nomination.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * Get the nominated user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nominee(){
        return $this->belongsTo('App\User','nominee_id','id');
    }

    /**
     * Get the category for the nomination
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
