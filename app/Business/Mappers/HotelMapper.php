<?php
namespace Franklin\App\Business\Mappers;

class HotelMapper {
    /**
     * Hotel name
     */
    private string $name;
    /**
     * Hotel Rating
     */
    private int $stars;
    /**
     * Hotel Rooms
     */
    private array $rooms = [];

    /**
     * Set rating value
     *
     * @param integer $stars
     * @return void
     */
    public function setStars(int $stars){
        $this->stars = $stars;
    }

    /**
     * Set hotel name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name){
        $this->name = $name;
    }

    /**
     * Set room array with RoomMapper instances
     *
     * @param RoomMapper ...$rooms
     * @return void
     */
    public function setRooms(RoomMapper ...$rooms){
        $this->rooms = $rooms;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getStars(): int{
        return $this->stars;
    }

    /**
     * Get hotel name
     *
     * @return string
     */
    public function getName(): string{
        return $this->name;
    }

    /**
     * Get hotel rooms
     *
     * @return array
     */
    public function getRooms(): array{
        return $this->rooms;
    }
}