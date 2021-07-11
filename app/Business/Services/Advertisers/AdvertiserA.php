<?php
namespace Franklin\App\Business\Services\Advertisers;

use Franklin\App\Business\Contracts\AdvertiserContract;
use Franklin\App\Business\Mappers\HotelMapper;
use Franklin\App\Business\Mappers\RoomMapper;
use Franklin\App\Business\Mappers\TaxMapper;

class AdvertiserA extends BaseAdvertiser implements AdvertiserContract{

    protected string $endpoint = "https://f704cb9e-bf27-440c-a927-4c8e57e3bad1.mock.pstmn.io/s1/availability";

    public function pollAds()
    {
        //make request
        $response = $this->makeJsonRequest();
        $hotels = $this->formatHotelData($response['hotels']);
        //save records
        $this->repository->saveHotel(...$hotels);
    }

    protected function formatHotelData(array $data): array{
        $mappers = array_map(function($val){
            $hotel = resolve(HotelMapper::class);
            $hotel->setName($val['name']);
            $hotel->setStars($val['stars']);
            $hotel->setRooms(...$this->formatRoomData($val['rooms']));
            return $hotel;
        },$data);
        
        return $mappers;
    }

    protected function formatRoomData(array $data): array{
        $mappers = array_map(function($val){
            $room = resolve(RoomMapper::class);
            $room->setCode($val['code']);
            $room->setNetAmount((float) $val['net_price']);
            $room->setTotalAmount((float) $val['total']);
            $room->setTaxes(...$this->formatTaxData($val['taxes']));
            return $room;
        }, $data);

        return $mappers;
    }

    protected function formatTaxData(array $data): array{
        if(!isset($data[0])){
            $data = [$data];
        }
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