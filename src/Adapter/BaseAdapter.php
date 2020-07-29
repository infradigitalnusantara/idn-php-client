<?php
namespace InfraDigital\ApiClient\Adapter;

use Http\Client\HttpClient;
use InfraDigital\ApiClient\Entity\MainEntity;
use InfraDigital\ApiClient\Utils\ClientUtil;

class BaseAdapter implements AdapterInterface
{
    private $httpClient;
    private $mainEntity;
    private $utils;
    private $httpResponse;
    private $httpResponseCode;
    private $httpRawResponse;

    public function __construct(MainEntity $mainEntity, ClientUtil $utils, HttpClient $httpClient)
    {
        $this->utils        = $utils;
        $this->mainEntity   = $mainEntity;
        $this->httpClient   = $httpClient;
    }

    protected function getMainEntity()
    {
        return $this->mainEntity;
    }

    protected function getUtils()
    {
        return $this->utils;
    }

    private function buildResponse($rawResponse)
    {
        $this->httpRawResponse  = $rawResponse;
        $this->httpResponseCode = $this->httpRawResponse->getStatusCode();
        $response               = $this->httpRawResponse->getBody()->__toString();
        $jsonResponse           = json_decode($response, true);
        $this->httpResponse     = (json_last_error() === JSON_ERROR_NONE) ? $jsonResponse : $response;
    }

    protected function httpGet($uri, array $headers = array())
    {
        $this->buildResponse($this->httpClient->get($uri, $headers));
    }

    protected function httpPost($uri, array $headers = array(), $body = null)
    {
        if ( ! empty($body)) {
            $body = (is_array($body)) ? json_encode($body) : $body;
            $headers = array_merge(array('Content-Type: application/json','Content-Length: ' . strlen($body)));
        }
        $this->buildResponse($this->httpClient->post($uri, $headers, $body));
    }

    protected function httpPut($uri, array $headers = array(), $body = null)
    {
        if ( ! empty($body)) {
            $body = (is_array($body)) ? json_encode($body) : $body;
            $headers = array_merge(array('Content-Type: application/json','Content-Length: ' . strlen($body)));
        }
        $this->buildResponse($this->httpClient->put($uri, $headers, $body));
    }

    public function getResponseCode()
    {
        return $this->httpResponseCode;
    }

    public function getResponse()
    {
        return $this->httpResponse;
    }

    public function getRawResponse()
    {
        return $this->httpRawResponse;
    }
}