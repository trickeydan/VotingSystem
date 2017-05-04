<?php

namespace App\Console\Commands;

use App\Category;
use App\System;
use App\User;
use App\Nomination;
use Illuminate\Console\Command;

class SimulateNominations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:nominations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomly nominate.';

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
        $this->info('Generating Nominations');
        foreach (User::whereAdmin(false)->get() as $user){
            $this->info($user->name);
            foreach (Category::all() as $category){

                if(Nomination::whereCategoryId($category->id)->whereUserId($user->id)->count() == 0){
                    Nomination::create([
                        'user_id' => $user->id,
                        'nominee_id' => User::where('id','!=',$user->id)->whereAdmin(false)->inRandomOrder()->first()->id,
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
