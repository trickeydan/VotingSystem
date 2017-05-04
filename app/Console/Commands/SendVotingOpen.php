<?php

namespace App\Console\Commands;

use App\Notifications\VotingOpen;
use Illuminate\Console\Command;
use App\User;

class SendVotingOpen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails informing that voting is now open.';

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
        $this->info('Emailing Users to inform them that voting is now open.');
        $user_count = User::whereAdmin(false)->count();
        $bar = $this->output->createProgressBar($user_count);
        foreach (User::whereAdmin(false)->get() as $user){
            $user->notify(new VotingOpen());
            $bar->advance();
        }
        $bar->finish();
        echo PHP_EOL;
        $this->info('Users have been emailed.');
    }
}
