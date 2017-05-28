<?php

namespace Nomad145\LinodeAlphaAPI;

use Nomad145\LinodeAlphaAPI\Auth\AccessToken;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Client
{
    /** @var AccessToken */
    protected $accessToken;

    /** @var ClientInterface */
    protected $httpClient;

    public function __construct(ClientInterface $httpClient, AccessToken $accessToken)
    {
        $this->httpClient = $httpClient;
        $this->accessToken = $accessToken;
    }

    /**
     * Getter for accessToken
     *
     * @return AccessToken
     */
    public function getAccessToken() : AccessToken
    {
        return $this->accessToken;
    }

    /**
     * Setter for accessToken
     *
     * @param AccessToken $accessToken
     * @return Client
     */
    public function setAccessToken(AccessToken $accessToken) : Client
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Getter for httpClient
     *
     * @return ClientInterface
     */
    public function getHttpClient() : ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Setter for httpClient
     *
     * @param ClientInterface $httpClient
     * @return Client
     */
    public function setHttpClient(ClientInterface $httpClient) : Client
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function call(string $method, string $route) : ResponseInterface
    {
        return $this->httpClient->request($method, $route, [
            "Authorization" => "token $this->accessToken"
        ]);
    }
}
