<?php namespace Geeky\Database;

use Illuminate\Console\Command;
use Cache;

class ClearBuilderCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache-builder:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush builder cache keys';


    /**
     * Create a new command instance.
     *
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
        Cache::store('cache-builder')->flush();

        $this->info('Cache builder keys cleared successfully');
    }
}
