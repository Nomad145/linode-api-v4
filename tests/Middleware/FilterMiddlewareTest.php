<?php

namespace Middleware;

use LinodeApi\Test\TestCase\MiddlewareTestCase;
use GuzzleHttp\Psr7\Request;
use LinodeApi\Middleware\FilterMiddleware;

/**
 * Class FilterMiddlewareTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class FilterMiddlewareTest extends MiddlewareTestCase
{
    public function testPagination()
    {
        $subject = new FilterMiddleware([
            'vendor' => 'Test'
        ]);

        $callable = $subject(self::handler());
        $this->assertInternalType('callable', $callable);

        $request = $callable($this->request, []);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(['{"vendor":"Test"}'], $request->getHeader('X-Filter'));
    }
}
