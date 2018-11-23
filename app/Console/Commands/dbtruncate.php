<?php

namespace App\Console\Commands;

use App\LoginToken;
use App\ResetToken;
use App\User;
use Illuminate\Console\Command;

class dbtruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbtruncate';

    /**
     * The console command description.
     *
     * @var string
     */


    protected $description = 'Deletes all the rows on tables';

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
        User::truncate();
        $this->info('User : is Empty');
        LoginToken::truncate();
        $this->info('LoginToken : is Empty');
        ResetToken::truncate();
        $this->info('ResetToken : is Empty');
    }
}
