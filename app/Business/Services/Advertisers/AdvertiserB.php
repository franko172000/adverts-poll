<?php
namespace Franklin\App\Business\Services\Advertisers;

use Franklin\App\Business\Contracts\AdvertiserContract;
use Franklin\App\Business\Mappers\HotelMapper;
use Franklin\App\Business\Mappers\RoomMapper;
use Franklin\App\Business\Mappers\TaxMapper;

class AdvertiserB extends BaseAdvertiser implements AdvertiserContract{

    protected string $endpoint = "https://f704cb9e-bf27-440c-a927-4c8e57e3bad1.mock.pstmn.io/s2/availability";

    /**
     * Get advert from remote server
     *
     * @return void
     */
    public function pollAds()
    {
        //make request
        $response = $this->makeJsonRequest();
        $hotels = $this->formatHotelData($response['hotels']);
        //save records
        $this->repository->saveHotel(...$hotels);
    }

    /**
     * Transform hotel data
     *
     * @param array $data
     * @return array
     */
    protected function formatHotelData(array $data): array{
        $mappers = [];
        $mappers = array_map(function($val){
            $hotel = resolve(HotelMapper::class);
            $hotel->setName($val['name']);
            $hotel->setStars($val['stars']);
            $hotel->setRooms(...$this->formatRoomData($val['rooms']));
            return $hotel;
        },$data);
        return $mappers;
    }

    /**
     * Transform Room Data
     *
     * @param array $data
     * @return array
     */
    protected function formatRoomData(array $data): array{
        $mappers = [];
        $mappers = array_map(function($val){
            $room = resolve(RoomMapper::class);
            $room->setName($val['name']);
            $room->setCode($val['code']);
            $room->setNetAmount((float) $val['net_rate']);
            $room->setTotalAmount((float) $val['totalPrice']);
            $room->setTaxes(...$this->formatTaxData($val['taxes']));
            return $room;
        }, $data);

        return $mappers;
    }

    /**
     * Transform Tax Data
     *
     * @param array $data
     * @return array
     */
    protected function formatTaxData(array $data): array{
        $mappers = [];
        $mappers = array_map(function($val){
            $tax = resolve(TaxMapper::class);
            $tax->setType($val['type']);
            $tax->setAmount((float) $val['amount']);
            $tax->setCurrency($val['currency']);
            return $tax;
        }, $data);

        return $mappers;
    }
}