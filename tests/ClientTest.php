<?php

namespace Nomad145\LinodeAlphaAPI\Test;

use Nomad145\LinodeAlphaAPI\Client;
use Nomad145\LinodeAlphaAPI\Auth\AccessToken;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Class ClientTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function testClient()
    {
        $subject = new Client();

        $accessToken = new AccessToken('token');
        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->method('request')
            ->willReturn(new Response());

        $subject->setAccessToken($accessToken);
        $subject->setHttpClient($httpClient);
        $subject->setBaseEndpoint('https://test.endpoint.com');

        $this->assertSame($accessToken, $subject->getAccessToken());
        $this->assertSame('https://test.endpoint.com', $subject->getBaseEndpoint());
        $this->assertInstanceOf(Response::class, $subject->call('GET', '/test'));
    }
}
