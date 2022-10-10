<?php

namespace App\Console\Commands;

use App\Services\TempFiles\TempFileClearService;
use Illuminate\Console\Command;

class ClearFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear files from temp directory and database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private TempFileClearService $tempFileClearService)
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
        $this->tempFileClearService->deleteDeprecatedFiles();

        return Command::SUCCESS;
    }
}
