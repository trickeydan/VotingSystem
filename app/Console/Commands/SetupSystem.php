<?php

namespace App\Console\Commands;

use App\Category;
use App\System;
use App\User;
use Illuminate\Console\Command;
use League\Csv\Reader;

class SetupSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the system.';

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
        $this->info('Setup System');
        $this->callSilent('down');
        $this->callSilent('migrate:refresh');

        $this->info('An administrator user needs to be created.');
        $admin_user = new User();
        $admin_user->admin = true;
        $admin_user->email = $this->ask('Administrator Email: ');
        $admin_user->name = $this->ask('Administrator Name: ');
        $admin_user->password = bcrypt($this->secret('Administrator Password: '));
        $admin_user->save();
        $this->info('Administrator user created.');

        $this->info('Importing Users');
        $reader = Reader::createFromPath(storage_path('users.csv'));
        foreach($reader->fetchAll() as $index => $row){
            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => bcrypt('password')
            ]);
        }
        $this->info('Imported All Users.');

        $this->info('Please enter the categories:');
        $loop = true;
        while($loop){
            $question = $this->ask('Category: ');
            Category::create(['title' => $question]);
            $loop = $this->confirm('Add another category? ');
        }

        $this->callSilent('up');
        $this->info('System live.');
        //Todo: Add Emails
        $this->info('Setup finished.');
    }
}
