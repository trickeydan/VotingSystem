<?php

namespace App\Console\Commands;

use App\Category;
use App\Notifications\AdminNewAccount;
use App\Notifications\UserWelcome;
use App\System;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
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
        $password = $this->secret('Administrator Password: ');
        $admin_user->password = bcrypt($password);
        $admin_user->save();
        $this->info('Administrator user created.');
        $admin_user->notify(new AdminNewAccount($password));

        $this->info('Importing Users');
        $reader = Reader::createFromPath(storage_path('users.csv'));
        foreach($reader->fetchAll() as $index => $row){
            $user = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => bcrypt('Temporary')
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

        $this->info('Emailing Users to inform them that nominations are now open.');
        $user_count = User::whereAdmin(false)->count();
        $bar = $this->output->createProgressBar($user_count);
        foreach (User::whereAdmin(false)->get() as $user){
            $password = Str::random(10);
            $user->password = bcrypt($password);
            $user->save();
            $user->notify(new UserWelcome($password));
            $bar->advance();
        }
        $bar->finish();
        echo PHP_EOL;
        $this->info('Users have been emailed.');
        $this->info('Setup finished.');
    }
}
