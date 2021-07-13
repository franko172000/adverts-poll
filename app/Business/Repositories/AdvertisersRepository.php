<?php
namespace Franklin\App\Business\Repositories;

use Franklin\App\Business\Mappers\HotelMapper;
use Franklin\App\Business\Mappers\RoomMapper;
use Franklin\App\Business\Mappers\TaxMapper;
use Franklin\App\Models\Hotels;
use Franklin\App\Models\Rooms;
use Illuminate\Support\Arr;

class AdvertisersRepository {
    protected Hotels $hotelEntity;
    protected Rooms $roomsEntity;

    /**
     * Init object
     *
     * @param Hotels $hotels
     * @param Rooms $rooms
     */
    public function __construct(Hotels $hotels, Rooms $rooms)
    {
        $this->hotelEntity = $hotels;
        $this->roomsEntity = $rooms;
    }


    /**
     * Save array of hotels
     *
     * @param HotelMapper ...$hotels
     * @return void
     */
    public function saveHotel(HotelMapper ...$hotels) {
        array_walk($hotels, function($hotel){
            $hotelObj = $this->hotelEntity->updateOrCreate([
                'name' => $hotel->getName(),
                'stars' => $hotel->getStars(),
            ]);
            //save rooms
            $this->saveRooms($hotelObj, ...$hotel->getRooms());
        });
        
    }

    /**
     * Save hotel rooms
     *
     * @param Hotels $hotel
     * @param RoomMapper ...$data
     * @return void
     */
    private function saveRooms(Hotels $hotel, RoomMapper ...$data){
        array_walk($data, function($val) use($hotel){
            $room = $this->roomsEntity
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

    /**
     * Save room taxes
     *
     * @param Rooms $room
     * @param TaxMapper ...$taxes
     * @return void
     */
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

    /**
     * Get rooms with filter options
     *
     * @param array $options
     * @return array
     */
    public function getRooms(array $options = []): array{

        $priceFrom = (float) Arr::get($options,'price_from', 0);
        $priceTo = (float) Arr::get($options,'price_to', 0);
        $limit = Arr::get($options,'limit', 20);
        $page = Arr::get($options,'page', 1);
        $offset = ($page - 1) * $limit;

        $obj = $this->roomsEntity
        ->orderBy('total_amount')
        ->with('hotel','taxes');

        if($priceFrom > 0 && $priceTo > 0){
            $obj = $obj->whereBetween('total_amount', [$priceFrom, $priceTo]);
        }

        if($priceFrom > 0 && $priceTo == 0){
            $obj = $obj->where('total_amount','>=', $priceFrom);
        }

        $total = $obj->count();
        $collection = $obj->limit($limit)
        ->offset($offset)
        ->get();

        return [$collection, $total];
    }
}