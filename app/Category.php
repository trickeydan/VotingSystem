<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use League\Csv\Writer;
use App\Nomination;

class Category extends Model
{
    protected $fillable = ['title'];

    /**
     * Get the nominees for this category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nominees(){
        return $this->hasMany('App\Nominee');
    }

    /**
     * Get the nominations for this category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nominations(){
        return $this->hasMany('App\Nomination');
    }

    /**
     * Get the votes for this category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes(){
        return $this->hasMany('App\Vote');
    }

    /**
     * Get an array of eligible people to vote for.
     *
     * @return array
     */
    public function getVotableArray(){
        $array = ['default' => 'Not Selected'];
        foreach ($this->nominees as $nominee){
            $array[$nominee->user->id] = $nominee->user->name;
        }
        return $array;
    }

    /**
     * Export the raw nominations for this category
     *
     * Will create a csv file at the location specified.
     *
     * It will detail exactly whom voted for whom.
     *
     * @param $location
     */
    public function exportNominationRaw($location){
        if(File::exists($location)) File::delete($location);
        File::put($location,'');
        $csv = Writer::createFromPath($location, "w");
        $csv->insertOne(['user', 'nominee',]); //Header
        foreach ($this->nominations as $nomination){
            $csv->insertOne([$nomination->user->name,$nomination->nominee->name]);
        }
    }

    /**
     * Export the summary numbers of the nominations for this category
     *
     * This function will create a .csv file at the location specified.
     *
     * @param $location
     */
    public function exportNominationSummary($location){
        $count = [];
        foreach ($this->nominations as $nomination){

            if(!isset($count[$nomination->nominee->name])){
                $count[$nomination->nominee->name] = 1;
            }else{
                $count[$nomination->nominee->name] += 1;
            }
        }
        arsort($count);
        reset($count);

        if(File::exists($location)) File::delete($location);
        File::put($location,'');

        $csv = Writer::createFromPath($location, "w");
        $csv->insertOne(['Name', 'Number of Nominations']); //Header

        foreach ($count as $key => $value){
            $csv->insertOne([$key,$value]);
        }
    }

    /**
     * Export the raw votes for this category
     *
     * Will create a csv file at the location specified.
     *
     * It will detail exactly whom voted for whom.
     *
     * @param $location
     */
    public function exportVoteRaw($location){
        if(File::exists($location)) File::delete($location);
        File::put($location,'');
        $csv = Writer::createFromPath($location, "w");
        $csv->insertOne(['user', 'vote',]); //Header
        foreach ($this->votes as $vote){
            $csv->insertOne([$vote->user->name,$vote->votee->name]);
        }
    }

    /**
     * Export the summary numbers of the votes for this category
     *
     * This function will create a .csv file at the location specified.
     *
     * @param $location
     */
    public function exportVoteSummary($location){
        $count = [];
        foreach ($this->votes as $vote){

            if(!isset($count[$vote->votee->name])){
                $count[$vote->votee->name] = 1;
            }else{
                $count[$vote->votee->name] += 1;
            }
        }
        arsort($count);
        reset($count);

        if(File::exists($location)) File::delete($location);
        File::put($location,'');

        $csv = Writer::createFromPath($location, "w");
        $csv->insertOne(['Name', 'Number of Votes']); //Header

        foreach ($count as $key => $value){
            $csv->insertOne([$key,$value]);
        }
    }
}
