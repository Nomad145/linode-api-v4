<?php

namespace LinodeApi\Request\Test;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;
use LinodeApi\Request\Persistor;
use LinodeApi\Model\Linode;
use LinodeApi\Exception\PersistenceException;
use LinodeApi\Hydrator;

/**
 * Class PersistorTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class PersistorTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $client = $this->createMock(ClientInterface::class);
        $builder = $this->createMock(RequestBuilder::class);
        $hydrator = $this->createMock(Hydrator::class);

        $builder
            ->expects($this->any())
            ->method(new \PHPUnit\Framework\Constraint\IsAnything())
            ->willReturn($this->returnSelf());

        $this->subject = new Persistor($client, $builder, $hydrator);
    }

    public function testDelete()
    {
        $this->expectException(PersistenceException::class);

        $model = $this->createMock(Linode::class);
        $this->subject->delete($model);
    }
}
