<?php

namespace Tests\Unit;

use Franklin\App\Business\Mappers\HotelMapper;
use Franklin\App\Business\Mappers\RoomMapper;
use Franklin\App\Business\Mappers\TaxMapper;
use Franklin\App\Business\Services\Advertisers\AdvertiserB;
use Franklin\App\Models\Hotels;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\AdvertisersTestSetup;

class AdvertiserBTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    use AdvertisersTestSetup;

    private $advertiserB;

    public function setUp(): void{
        parent::setUp();
        $this->setUpAdvertiserB();

        $this->advertiserA = app(AdvertiserB::class);
    }

    /**
     * Test Advert are polled and saved
     *
     * @return void
     */
    public function testServiceCanPollAds()
    {
        $this->advertiserA->pollAds();
        $data = $this->mockResponseB()['hotels'];
        $orgHotel = $data[0];
        $hotels = Hotels::with('rooms','rooms.taxes')->get();
        $dbHotel = $hotels[0];
        $this->assertEquals(count($data), $hotels->count());
        $this->assertEquals(count($data[0]['rooms']), $hotels[0]->rooms()->count());
        $this->assertEquals(count($data[0]['rooms'][0]['taxes']), $hotels[0]->rooms[0]->taxes->count());
        $this->assertEquals($orgHotel['name'], $dbHotel->name);
        $this->assertEquals($orgHotel['stars'], $dbHotel->stars);
    }

    public function testFormatHotelData(){
        $reflection = new \ReflectionClass(get_class($this->advertiserA));
        $data = $this->mockResponseB();
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
