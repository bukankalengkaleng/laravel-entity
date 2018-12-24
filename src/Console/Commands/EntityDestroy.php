<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EntityDestroy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entity:destroy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy an entity along with their artefacts';

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
        //
    }
}
