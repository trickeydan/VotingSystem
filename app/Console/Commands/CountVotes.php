<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;
use App\Vote;
use App\User;

class CountVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count the Votes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = [];
        $this->info('Counting Votes and displaying Winner in each category');
        foreach (Category::all() as $category) {
            $this->info('Category: ' . $category->title);
            foreach (Vote::whereCategoryId($category->id)->get() as $vote){
                if(!isset($count[$category->id][$vote->votee->name])){
                    $count[$category->id][$vote->votee->name] = 1;
                }else{
                    $count[$category->id][$vote->votee->name] += 1;
                }

            }
            arsort($count[$category->id]);

            reset($count[$category->id]);

            $winner = each($count[$category->id]);

            $this->info('      ' . $winner["key"] . ' : ' . $winner["value"]);
        }
    }
}
