<?php

namespace Tests\Traits;

use Franklin\App\Business\Repositories\AdvertisersRepository;
use Franklin\App\Business\Services\Advertisers\AdvertiserB;
use Franklin\App\Business\Services\Advertisers\AdvertiserA;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response as GuzzleReponse;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

trait AdvertisersTestSetup{
    use MockResponse;
    
    public function mockDependencies(): array{
        $mockHandler = new MockHandler();
        $handler = HandlerStack::create($mockHandler);
  
        $client = new GuzzleClient(['handler' => $handler]);

        $repository = app(AdvertisersRepository::class);

        return[
            $mockHandler,
            $client,
            $repository
        ];
    }

    public function setUpAdvertiserB(){
        [
            $mockHandler,
            $client,
            $repository
        ] = $this->mockDependencies();
        $this->app->singleton(AdvertiserB::class, function () use ($client, $repository) {
            return new AdvertiserB($client, $repository);
        });
        $mockHandler->append(new GuzzleReponse(200, [], json_encode($this->mockResponseB())));
    }

    public function setUpAdvertiserA(){
        [
            $mockHandler,
            $client,
            $repository
        ] = $this->mockDependencies();
        $this->app->singleton(AdvertiserA::class, function () use ($client, $repository) {
            return new AdvertiserA($client, $repository);
        });
        $mockHandler->append(new GuzzleReponse(200, [], json_encode($this->mockResponseA())));
    }
}