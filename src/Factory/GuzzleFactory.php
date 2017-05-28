<?php

namespace LinodeApi\Factory;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

/**
 * Class GuzzleFactory
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class GuzzleFactory
{
    protected $baseEndpoint;

    public function __construct(string $baseEndpoint)
    {
        $this->endpoint = $baseEndpoint;
    }

    public function create(array $middleware = [])
    {
        $stack = HandlerStack::create();
        array_walk($middleware, [$stack, 'push']);

        return new Client([
            'handler' => $stack,
            'base_uri' => $this->endpoint,
        ]);
    }
}
