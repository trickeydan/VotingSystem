<?php

namespace App\Console;

use App\Console\Commands\CountNominations;
use App\Console\Commands\CountVotes;
use App\Console\Commands\DataExport;
use App\Console\Commands\ImportPeople;
use App\Console\Commands\NominationNotifySend;
use App\Console\Commands\SendVotingOpen;
use App\Console\Commands\SetupSystem;
use App\Console\Commands\SimulateNominations;
use App\Console\Commands\SimulateVotes;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SetupSystem::class,
        CountNominations::class,
        CountVotes::class,
        SendVotingOpen::class,
        NominationNotifySend::class,

        SimulateNominations::class,
        SimulateVotes::class,
        DataExport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
