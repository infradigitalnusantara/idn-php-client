<?php
namespace InfraDigital\ApiClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use InfraDigital\ApiClient\Adapter;

class Client extends BaseClient
{
    /**
     * @var Adapter\StudentAdapter
     */
    private $studentApi;

    public function __construct($username, $plainPassword)
    {
        parent::__construct($username, $plainPassword);
        $this->initAdapter();
    }

    private function initAdapter()
    {
        $this->studentApi = new Adapter\StudentAdapter(
            $this->mainEntity,
            $this->utils,
            new HttpMethodsClient(
                HttpClientDiscovery::find(),
                MessageFactoryDiscovery::find()
            )
        );
    }

    /**
     * @return Adapter\StudentAdapter
     */
    public function studentApi()
    {
        return $this->studentApi;
    }
}