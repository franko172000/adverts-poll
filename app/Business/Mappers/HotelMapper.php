<?php
namespace Franklin\App\Business\Mappers;

class HotelMapper {
    private string $name;
    private int $stars;
    private array $rooms = [];

    public function setStars(int $stars){
        $this->stars = $stars;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function setRooms(RoomMapper ...$rooms){
        $this->rooms = $rooms;
    }

    public function getStars(){
        return $this->stars;
    }

    public function getName(){
        return $this->name;
    }

    public function getRooms(){
        return $this->rooms;
    }
}