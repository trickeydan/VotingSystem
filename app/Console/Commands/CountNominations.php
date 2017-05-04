<?php

namespace App\Console\Commands;

use App\Category;
use App\Nomination;
use App\Nominee;
use Illuminate\Console\Command;
use App\User;

class CountNominations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:nominate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile the votes for nominations.';

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
        $this->callSilent('down');
        $this->info('Deleting any previous nominees');
        Nominee::getQuery()->delete();

        $count = [];
        $this->info('Counting Nomination Votes');
        foreach (Category::all() as $category) {
            $this->info('Category: ' . $category->title);
            foreach (Nomination::whereCategoryId($category->id)->get() as $nomination){
                if(!isset($count[$category->id][$nomination->nominee->id])){
                    $count[$category->id][$nomination->nominee->id] = 1;
                }else{
                    $count[$category->id][$nomination->nominee->id] += 1;
                }

            }
            arsort($count[$category->id]);

            reset($count[$category->id]);
            for($i = 1;$i <= config('app.nomineecount');$i++ ){

                $nominee_info = each($count[$category->id]);
                $nominee = User::find($nominee_info["key"]);
                $this->info('      ' . $nominee->name . ' : ' . $nominee_info["value"]);
                Nominee::create([
                    'category_id' => $category->id,
                    'user_id' => $nominee->id,
                ]);
            }
        }
        $this->info('Nominations Counted and stored in database.');
        $this->info('You can now switch to voting mode');
    }
}
