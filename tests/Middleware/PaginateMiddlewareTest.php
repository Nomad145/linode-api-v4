<?php

namespace Middleware;

use LinodeApi\Test\TestCase\MiddlewareTestCase;
use GuzzleHttp\Psr7\Request;
use LinodeApi\Middleware\PaginateMiddleware;

/**
 * Class PaginateMiddlewareTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class PaginateMiddlewareTest extends MiddlewareTestCase
{
    public function testPagination()
    {
        $subject = new PaginateMiddleware(2);

        $callable = $subject(self::handler());
        $this->assertInternalType('callable', $callable);

        $request = $callable($this->request, []);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('page=2', $request->getUri()->getQuery());
    }
}
