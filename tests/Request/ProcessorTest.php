<?php

namespace LinodeApi\Request\Test;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;

/**
 * Class ProcessorTest
 * @author Michael Phillips <michael.phillips@manpow.com>
 */
class ProcessorTest
{
    public function testProcessorCreate()
    {
        $client = $this->createMock(ClientInterface::class);
        $builder = $this->createMock(RequestBuilder::class);
    }
}
