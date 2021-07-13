<?php
namespace Franklin\App\Business\Repositories;

use Franklin\App\Business\Mappers\HotelMapper;
use Franklin\App\Business\Mappers\RoomMapper;
use Franklin\App\Business\Mappers\TaxMapper;
use Franklin\App\Models\Hotels;
use Franklin\App\Models\Rooms;
use Illuminate\Support\Arr;

class AdvertisersRepository {
    protected Hotels $hotelEnitity;
    protected Rooms $roomsEnitity;

    public function __construct(Hotels $hotels, Rooms $rooms)
    {
        $this->hotelEnitity = $hotels;
        $this->roomsEnitity = $rooms;
    }

    public function saveHotel(HotelMapper ...$hotels) {
        array_walk($hotels, function($hotel){
            $hotelObj = $this->hotelEnitity->updateOrCreate([
                'name' => $hotel->getName(),
                'stars' => $hotel->getStars(),
            ]);
            //save rooms
            $this->saveRooms($hotelObj, ...$hotel->getRooms());
        });
        
    }

    private function saveRooms(Hotels $hotel, RoomMapper ...$data){
        array_walk($data, function($val) use($hotel){
            $room = $this->roomsEnitity
            ->where('code', $val->getCode())
            ->where('hotel_id', $hotel->id)
            ->first();
            if($room !== null){
                if( $room->total_amount > $val->getTotalAmount()){
                    //update room with new price
                    $room->total_amount = $val->getTotalAmount();
                    $room->name = $val->getName();
                    $room->net_amount = $val->getNetAmount();
                    $hotel->rooms()->save($room);

                    $this->saveTaxes($room, ...$val->getTaxes());
                }
            }else{
                $room = $hotel->rooms()->create([
                    'code' => $val->getCode(),
                    'name' => $val->getName(),
                    'net_amount' => $val->getNetAmount(),
                    'total_amount' => $val->getTotalAmount(),
                ]);
                $this->saveTaxes($room, ...$val->getTaxes());
            }
        });
    }

    private function saveTaxes(Rooms $room, TaxMapper ...$taxes){
        //delete existing tax records for the room
        $room->taxes()->delete();
        //create new tax records
        array_walk($taxes, function($val, $key) use ($room){
            $room->taxes()->create([
                'type'=>$val->getType(),
                'amount'=>$val->getAmount(),
                'currency'=>$val->getCurrency(),
            ]);
        });
    }

    public function getRooms(array $options = []){

        $priceFrom = (float) Arr::get($options,'price_from', 0);
        $priceTo = (float) Arr::get($options,'price_to', 0);
        $limit = Arr::get($options,'limit', 0);

        $obj = $this->roomsEnitity
        ->orderBy('total_amount')
        ->with('hotel','taxes');

        if($priceFrom > 0 && $priceTo > 0){
            $obj = $obj->whereBetween('total_amount', [$priceFrom, $priceTo]);
        }

        if($priceFrom > 0 && $priceTo == 0){
            $obj = $obj->where('total_amount','>=', $priceFrom);
        }

        if($limit > 0){
            $obj = $obj->limit($limit);
        }

        return $obj->get();
    }
}