<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Franklin\App\Models\Hotels;
use Franklin\App\Models\Rooms;
use Tests\TestCase;
use Tests\Traits\AdvertisersTestSetup;
use Tests\Traits\MockResponse;

class PollAdsCommandTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;
    use AdvertisersTestSetup;

    public function setUp(): void {
        parent::setUp();
        $this->setUpAdvertiserA();
        $this->setUpAdvertiserB();
    }
   
    public function testPollAdsCommands()
    {
        $this->artisan('adverts:poll')
        ->expectsOutput('Polling started')
        ->expectsOutput('Polling completed')
        ->assertExitCode(0);

        $this->assertDatabaseCount(Hotels::class, 4);
        $this->assertDatabaseHas(Hotels::class, [
            'name' => 'Hotel Test A',
            'stars' => 4
        ]);
        $this->assertDatabaseHas(Hotels::class, [
            'name' => 'Hotel Test B',
            'stars' => 5
        ]);
        $this->assertDatabaseHas(Hotels::class, [
            'name' => 'Hotel Test C',
            'stars' => 5
        ]);
        $this->assertDatabaseHas(Hotels::class, [
            'name' => 'Hotel Test D',
            'stars' => 5
        ]);

        $room = Rooms::where('code', 'DBL-TWN')->get();
        $this->assertEquals(1,$room->count());
        $this->assertDatabaseHas(Rooms::class, [
            "id"=> 1,
            "hotel_id"=>1,
            "code"=> "DBL-TWN",
            "net_amount"=> "140.00",
            "total_amount"=> "152",
        ]);
    }


}
