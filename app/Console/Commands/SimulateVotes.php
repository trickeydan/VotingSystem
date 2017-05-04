<?php

namespace App\Console\Commands;

use App\Nominee;
use App\Vote;
use Illuminate\Console\Command;
use App\User;
use App\Category;

class SimulateVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomly vote.';

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
        $this->info('Generating Votes');
        foreach (User::whereAdmin(false)->get() as $user){
            $this->info($user->name);
            foreach (Category::all() as $category){

                if(Vote::whereCategoryId($category->id)->whereUserId($user->id)->count() == 0){
                    Vote::create([
                        'user_id' => $user->id,
                        'votee_id' => Nominee::whereCategoryId($category->id)->inRandomOrder()->first()->user_id,
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
