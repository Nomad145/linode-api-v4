<?php

namespace LinodeApi\Test\Factory;

use LinodeApi\Factory\GuzzleFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

/**
 * Class GuzzleFactoryTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class GuzzleFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testGuzzleFactory()
    {
        $subject = new GuzzleFactory();
        $middleware = function () {
            return;
        };

        $client = $subject->getClient('https://test.endpoint.com', [
            'TestMiddleware' => $middleware
        ]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(Uri::class, $client->getConfig()['base_uri']);
        $this->assertSame('test.endpoint.com', $client->getConfig()['base_uri']->getHost());
    }
}
