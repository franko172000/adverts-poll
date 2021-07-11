<?php
namespace Franklin\App\Business\Services\Advertisers;

use Franklin\App\Business\Repositories\AdvertisersRepository;

class AdvertiserService {
    private AdvertisersRepository $repository;

    public function __construct(AdvertisersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRooms(){
        return $this->repository->getRooms();
    }
}