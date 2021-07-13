<?php

namespace Franklin\App\Console\Commands;

use Franklin\App\Business\Contracts\AdvertiserContract;
use Franklin\App\Business\Services\Advertisers\AdvertiserA;
use Franklin\App\Business\Services\Advertisers\AdvertiserB;
use Illuminate\Console\Command;

class PollAdverts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adverts:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command polls adverts from different vendors via an API request and persists the data in the database.';

    protected array $advertisers = [
        AdvertiserA::class,
        AdvertiserB::class,
    ];
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
        $this->info("Polling started");
        array_walk($this->advertisers, function($val){
            $advertiser = resolve($val);
            if($advertiser instanceof AdvertiserContract){
                $advertiser->pollAds();
            }
        });
        $this->info("Polling completed");
    }
}
