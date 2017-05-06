<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DataExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the data into .csv files.';

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
        $this->info('Exporting Nomination data to ' . storage_path('export/nomination'));
        $this->info('Exporting Voting data to ' . storage_path('export/vote'));
        if(!File::exists(storage_path('export/nomination'))) File::makeDirectory(storage_path('export/nomination'));
        if(!File::exists(storage_path('export/vote'))) File::makeDirectory(storage_path('export/vote'));
        foreach(Category::all() as $category){
            $category->exportNominationRaw(storage_path('export/nomination/' . str_replace(' ','',$category->title) . '_raw.csv'));
            $category->exportNominationSummary(storage_path('export/nomination/' . str_replace(' ','',$category->title) . '_summary.csv'));
            $this->info('Exported Nominations for: ' . $category->title);
            $category->exportVoteRaw(storage_path('export/vote/' . str_replace(' ','',$category->title) . '_raw.csv'));
            $category->exportVoteSummary(storage_path('export/vote/' . str_replace(' ','',$category->title) . '_summary.csv'));
            $this->info('Exported Votes for: ' . $category->title);
        }
    }
}
