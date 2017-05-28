<?php

namespace LinodeApi\Test\TestCase;

use GuzzleHttp\Psr7\Request;

/**
 * Class MiddlewareTestCase
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
abstract class MiddlewareTestCase extends \PHPUnit\Framework\TestCase
{
    public static function handler()
    {
        return function ($request, $options) {
            return $request;
        };
    }

    public function setUp()
    {
        $this->request = new Request('GET', 'http://test.endpoint.com');
    }
}
