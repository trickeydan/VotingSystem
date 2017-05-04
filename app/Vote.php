<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id','votee_id','category_id'];
    /**
     * Get the user that cast this vote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * Get the voted user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function votee(){
        return $this->belongsTo('App\User','votee_id','id');
    }

    /**
     * Get the category for the vote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
