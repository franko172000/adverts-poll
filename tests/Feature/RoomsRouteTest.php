<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tests\Traits\AdvertisersTestSetup;

class RoomsRouteTest extends TestCase
{
   use DatabaseTransactions;
   use DatabaseMigrations;
   use AdvertisersTestSetup;

    public function setUp(): void {
        parent::setUp();
        $this->setUpAdvertiserA();
        $this->setUpAdvertiserB();
        Artisan::call('adverts:poll');
    }

    /**
     * Test response structure
     *
     * @return void
     */
    public function testCanReturnRoomsDataStructure()
    {
        $response = $this->get('api/rooms');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'room',
                    'code',
                    'hotel',
                    'hotelStars',
                    'taxes',
                    'totalTax',
                    'netPrice',
                    'totalPrice'
                ],
            ],
            'totalFiltered',
            'totalRecords'
        ]);
    }

    /**
     * Test rooms are returned
     *
     * @return void
     */
    public function testCanReturnRooms()
    {
        $mocks = $this->mockDependencies();
        $repository = $mocks[2];
        $collections = $repository->getRooms()[0];
        $rooms = $collections[0];
        $response = $this->get('api/rooms');
        $data = json_decode($response->content(), true);
        $content = $data['data'][0];
        $response->assertStatus(200);
        $this->assertEquals(count($data['data']), 12);
        $this->assertArrayHasKey('room',$content);
        $this->assertEquals($rooms->name,$content['room']);
        $this->assertArrayHasKey('code',$content);
        $this->assertEquals($rooms->code,$content['code']);
        $this->assertArrayHasKey('hotel',$content);
        $this->assertEquals($rooms->hotel->name,$content['hotel']);
        $this->assertArrayHasKey('hotelStars',$content);
        $this->assertEquals($rooms->hotel->stars,$content['hotelStars']);
    }

    /**
     * Test limit works
     *
     * @return void
     */
    public function testCanLimitRooms()
    {
        $response = $this->get('api/rooms?limit=2');
        $data = json_decode($response->content(), true);
        $response->assertStatus(200);
        $this->assertEquals(count($data['data']), 2);
    }

    /**
     * Test service can filter result
     *
     * @return void
     */
    public function testCanReturnRoomsWithMinimumSpecifiedAmount()
    {
        $response = $this->get('api/rooms?price_from=169');
        $data = json_decode($response->content(), true);
        $response->assertStatus(200);
        $this->assertEquals(count($data['data']), 4);
        $this->assertEquals($data['data'][0]['totalPrice'], '169.00');
    }
}
