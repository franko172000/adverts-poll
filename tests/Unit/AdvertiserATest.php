<?php

namespace Tests\Unit;

use Franklin\App\Business\Mappers\HotelMapper;
use Franklin\App\Business\Mappers\RoomMapper;
use Franklin\App\Business\Mappers\TaxMapper;
use Franklin\App\Business\Services\Advertisers\AdvertiserA;
use Franklin\App\Models\Hotels;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\AdvertisersTestSetup;

class AdvertiserATest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    use AdvertisersTestSetup;

    private $advertiserA;


    public function setUp(): void{
        parent::setUp();
        $this->setUpAdvertiserA();
        $this->advertiserA = app(AdvertiserA::class);
    }

    /**
     * Test Advert are polled and saved
     *
     * @return void
     */
    public function testServiceCanPollAds()
    {
        $this->advertiserA->pollAds();
        $data = $this->mockResponseA()['hotels'];
        $orgTax = $data[0]['rooms'][0]['taxes'];
        $hotels = Hotels::with('rooms','rooms.taxes')->get();
        $dbtax = $hotels[0]->rooms[0]->taxes[0];
        $this->assertEquals(count($data), $hotels->count());
        $this->assertEquals(count($data[0]['rooms']), $hotels[0]->rooms->count());
        $this->assertEquals($orgTax['amount'], $dbtax->amount);
        $this->assertEquals($orgTax['currency'], $dbtax->currency);
        $this->assertEquals($orgTax['type'], $dbtax->type);
    }

    public function testFormatHotelData(){
        $reflection = new \ReflectionClass(get_class($this->advertiserA));
        $data = $this->mockResponseA();
        $method = $reflection->getMethod('formatHotelData');
        $method->setAccessible(true);
        $result = $method->invokeArgs($this->advertiserA, [
            $data['hotels']
        ]);

        $roomMappers = $result[0]->getRooms();
        $taxMappers = $roomMappers[0]->getTaxes();
        $this->assertContainsOnlyInstancesOf(HotelMapper::class, $result);
        $this->assertContainsOnlyInstancesOf(RoomMapper::class, $roomMappers);
        $this->assertContainsOnlyInstancesOf(TaxMapper::class, $taxMappers);
    }
}
