<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class Fake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fake seeders';

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
     * @return int
     */
    public function handle()
    {
        $tables = [
            'Departments',
            'Cities',
            'Roles',
            'Users',
            'CarMarks',
            'CarModels',
            'Clients',
            'Cars',
            'FinanceGroups',
            'Finances',
            'Storages',
            'Producers',
            'Products',
            'Orders',
            'Tasks',
            'Checkboxes',
            'Pipelines',
            'Stages',
            'PipelineTask',
            'Comments',
            'MapQuestions',
            'AppealReasons',
            'ProcessCategories',
            'ProcessTasks',
            'DocumentTemplates'
        ];

        Artisan::call('permission:cache-reset');

        foreach ($tables as $table) {
            Artisan::call('db:seed', ['--class' => 'Database\Seeders\Fakes\Fake'.$table.'TableSeeder']);
            $this->info('fake '.mb_strtolower($table).' - done!');
        }

        return Command::SUCCESS;
    }
}
