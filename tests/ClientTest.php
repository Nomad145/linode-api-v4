<?php

namespace LinodeApiTest;

use LinodeApi\Client;
use LinodeApi\Auth\AccessToken;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Class ClientTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function testCall()
    {
        $accessToken = new AccessToken('token');
        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->method('request')
            ->willReturn(new Response());

        $subject = new Client($httpClient, $accessToken);

        $this->assertInstanceOf(Response::class, $subject->call('GET', '/test'));
    }
}
