<?php
namespace Franklin\App\Business\Services\Advertisers;

use Franklin\App\Business\Repositories\AdvertisersRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

abstract class BaseAdvertiser{
    protected string $endpoint;
    protected Client $client;
    protected array $headers = [];

    protected AdvertisersRepository $repository;

    /**
     * Init class
     *
     * @param GuzzleHttp\Client $guzzle
     * @param Franklin\App\Business\Repositories\AdvertisersRepository $repository
     */
    public function __construct(Client $guzzle, AdvertisersRepository $repository)
    {
        $this->repository = $repository;
        $this->client = $guzzle;
    }

    /**
     * Undocumented function
     *
     * @param array $reqHeader
     * @return Psr\Http\Message\ResponseInterface
     */
    protected function apiRequest(array $reqHeader = []): ResponseInterface{
        $headers = array_merge($this->headers, $reqHeader);
        return $this->client->get($this->endpoint, [
            'headers' =>  $headers
        ]);
    }

    /**
     * Make Json request
     *
     * @return array
     */
    protected function makeJsonRequest(): array{
        try{
            $response = $this->apiRequest();
            return json_decode($response->getBody(), true);
        }catch(ClientException $e){
            return json_decode($e->getResponse()->getBody(), true);
        }
    }

    /**
     * Make XML request
     *
     * @return \SimpleXMLElement
     */
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