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
    private $advertiser2;
    public function __construct(AdvertiserService $advertiser)
    {
        $this->advertiser = $advertiser;
    }
    
    public function getRooms(Request $request){
        $params = $request->all();
        $rooms = $this->advertiser->getRooms($params);
        return RoomsResource::collection($rooms);
    }
}
