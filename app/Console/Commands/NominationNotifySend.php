<?php

namespace App\Console\Commands;

use App\Nominee;
use App\Notifications\NominatedNotification;
use Illuminate\Console\Command;

class NominationNotifySend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:notify:nominated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inform users that they have been nominated.';

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
        $count = Nominee::all()->count();
        if($count == 0){
            $this->error('No nominees');
        }
        else{
            $this->info('Sending emails');
            $bar = $this->output->createProgressBar($count);
            foreach (Nominee::all() as $nominee){
                $nominee->user->notify(new NominatedNotification($nominee->category->title));
                $bar->advance();
            }
            $bar->finish();
            echo PHP_EOL;
        }
    }
}
