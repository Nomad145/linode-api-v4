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
    public function getClient(string $baseEndpoint, array $middleware = [])
    {
        $stack = HandlerStack::create();
        array_walk($middleware, [$stack, 'push']);

        return new Client([
            'handler' => $stack,
            'base_uri' => $baseEndpoint,
        ]);
    }
}
