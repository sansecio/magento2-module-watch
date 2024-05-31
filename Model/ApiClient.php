<?php

namespace Sansec\Watch\Model;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;

class ApiClient
{
    private ClientFactory $clientFactory;
    private Config $config;

    public function __construct(
        ClientFactory $clientFactory,
        Config $config
    ) {
        $this->clientFactory = $clientFactory;
        $this->config = $config;
    }

    public function getPolicy(): array
    {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [/* TODO: remove prior to publish */ 'verify' => false]]);
        $apiUrl = $this->config->getApiUrl();
        return json_Decode($client->get($apiUrl)->getBody()->getContents(), true);
    }
}
