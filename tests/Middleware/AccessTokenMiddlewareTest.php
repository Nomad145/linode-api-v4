<?php

namespace LinodeApi\Test\Middleware;

use GuzzleHttp\Psr7\Request;
use LinodeApi\Middleware\AccessTokenMiddleware;
use LinodeApi\Auth\AccessToken;
use LinodeApi\Test\TestCase\MiddlewareTestCase;

/**
 * Class AccessTokenMiddlewareTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class AccessTokenMiddlewareTest extends MiddlewareTestCase
{
    public function testMiddleware()
    {
        $subject = new AccessTokenMiddleware(new AccessToken('test_token'));
        $request = new Request('GET', 'http://test.endpoint.com');

        $callable = $subject(self::handler());
        $this->assertInternalType('callable', $callable);

        $request = $callable($request, []);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(['token test_token'], $request->getHeader('Authorization'));
    }
}
