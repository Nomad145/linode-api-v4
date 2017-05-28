<?php

namespace LinodeApi\Test\Middleware;

use GuzzleHttp\Psr7\Request;
use LinodeApi\Auth\AccessToken;
use LinodeApi\Middleware\JsonContentTypeMiddleware;
use LinodeApi\Test\TestCase\MiddlewareTestCase;

/**
 * Class JsonContentTypeMiddleware
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class JsonContentTypeMiddlewareTest extends MiddlewareTestCase
{
    public function testMiddleware()
    {
        $subject = new JsonContentTypeMiddleware();

        $callable = $subject(self::handler());
        $this->assertInternalType('callable', $callable);

        $request = $callable($this->request, []);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(['application/json'], $request->getHeader('Content-Type'));
    }
}
