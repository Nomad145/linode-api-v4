<?php

namespace LinodeApi\Request\Test;

use LinodeApi\Request\RequestBuilder;
use GuzzleHttp\Psr7\Request;

/**
 * Class RequestBuilderTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class RequestBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testRequestBuilder()
    {
        $subject = new RequestBuilder();

        $subject
            ->setMethod('POST')
            ->setUri('/linode/instances');

        $request = $subject->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/linode/instances', $request->getUri()->getPath());
    }
}
