<?php

namespace Franklin\App\Http\Controllers;

use Franklin\App\Business\Services\Advertisers\AdvertiserA;
use Franklin\App\Business\Services\Advertisers\AdvertiserB;
use Franklin\App\Business\Services\Advertisers\AdvertiserService;
use Franklin\App\Http\Resources\RoomsResource;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $advertiser;

    /**
     * Init controller class
     *
     * @param Franklin\App\Business\Services\Advertisers\AdvertiserService $advertiser
     */
    public function __construct(AdvertiserService $advertiser)
    {
        $this->advertiser = $advertiser;
    }
    
    /**
     * Get rooms
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function getRooms(Request $request){
        $params = $request->all();
        [$collections, $total] = $this->advertiser->getRooms($params);
        return RoomsResource::collection($collections)->additional([
            'totalFiltered' => $collections->count(),
            'totalRecords' => $total
        ]);
    }
}
