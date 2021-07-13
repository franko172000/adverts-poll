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
                ]
            ]
        ]);
    }

    public function testCanReturnRooms()
    {
        $mocks = $this->mockDependencies();
        $repository = $mocks[2];
        $rooms = $repository->getRooms()[0];
        $response = $this->get('api/rooms');
        $data = json_decode($response->content(), true);
        $response->assertStatus(200);
        $this->assertEquals(count($data['data']), 12);
        $this->assertArrayHasKey('room',$data['data'][0]);
        $this->assertEquals($rooms->name,$data['data'][0]['room']);
        $this->assertArrayHasKey('code',$data['data'][0]);
        $this->assertEquals($rooms->code,$data['data'][0]['code']);
        $this->assertArrayHasKey('hotel',$data['data'][0]);
        $this->assertEquals($rooms->hotel->name,$data['data'][0]['hotel']);
        $this->assertArrayHasKey('hotelStars',$data['data'][0]);
        $this->assertEquals($rooms->hotel->stars,$data['data'][0]['hotelStars']);
    }

    public function testCanLimitRooms()
    {
        $response = $this->get('api/rooms?limit=2');
        $data = json_decode($response->content(), true);
        $response->assertStatus(200);
        $this->assertEquals(count($data['data']), 2);
    }

    public function testCanReturnRoomsWithMinimumSpecifiedAmount()
    {
        $response = $this->get('api/rooms?price_from=169');
        $data = json_decode($response->content(), true);
        $response->assertStatus(200);
        $this->assertEquals(count($data['data']), 4);
        $this->assertEquals($data['data'][0]['totalPrice'], '169.00');
    }
}
