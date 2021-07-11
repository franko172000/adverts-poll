<?php
namespace Franklin\App\Business\Services\Advertisers;

use Franklin\App\Business\Repositories\AdvertisersRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class BaseAdvertiser{
    protected string $endpoint;
    protected Client $client;
    protected array $headers = [];

    protected AdvertisersRepository $repository;

    public function __construct(Client $guzzle, AdvertisersRepository $repository)
    {
        $this->repository = $repository;
        $this->client = $guzzle;
    }

    protected function apiRequest(array $reqHeader = []){
        $headers = array_merge($this->headers, $reqHeader);
        return $this->client->get($this->endpoint, [
            'headers' =>  $headers
        ]);
    }

    protected function makeJsonRequest(): array{
        try{
            $response = $this->apiRequest();
            return json_decode($response->getBody(), true);
        }catch(ClientException $e){
            return json_decode($e->getResponse()->getBody(), true);
        }
    }

    protected function makeXMLRequest(): \SimpleXMLElement{
        $content = "";
        try{
            $response = $this->apiRequest(['Accept' => 'application/xml']);
            $content = $response->getBody()->getContents();
        }catch(ClientException $e){
            $content = $e->getResponse()->getBody()->getContents();
        }
        return  new \SimpleXMLElement($content);
    }
}