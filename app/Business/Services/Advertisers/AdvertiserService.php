<?php
namespace Franklin\App\Business\Services\Advertisers;

use Franklin\App\Business\Repositories\AdvertisersRepository;

class AdvertiserService {
    private AdvertisersRepository $repository;

    /**
     * Init Service Class
     *
     * @param AdvertisersRepository $repository
     */
    public function __construct(AdvertisersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get Rooms from DB
     *
     * @param array $params
     * @return array
     */
    public function getRooms(array $params): array{
        return $this->repository->getRooms($params);
    }
}