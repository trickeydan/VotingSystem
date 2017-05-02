<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

use League\Csv\Reader;

class ImportPeople extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:people';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import People';

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
        $this->info('Deleting Users');
        User::getQuery()->delete();
        $this->info('Importing Users');
        $reader = Reader::createFromPath(storage_path('users.csv'));
        foreach($reader->fetchAll() as $index => $row){
            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => bcrypt('password')
            ]);
        }
        $this->info('Done.');
    }
}
