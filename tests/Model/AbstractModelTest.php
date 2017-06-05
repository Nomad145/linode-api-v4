<?php

namespace LinodeApi\Model\Test;

use GuzzleHttp\ClientInterface;
use LinodeApi\Model\AbstractModel;
use LinodeApi\Request\Persistor;
use LinodeApi\Exception\ModelNotInitializedException;

/**
 * Class AbstractModelTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class AbstractModelTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->subject = $this
            ->getMockBuilder(AbstractModel::class)
            ->getMockForAbstractClass();
    }

    public function testSetClient()
    {
        $client = $this->createMock(ClientInterface::class);
        $this->subject->setClient($client);

        $reflection = new \ReflectionClass(AbstractModel::class);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);

        $this->assertSame($client, $property->getValue($this->subject));
    }

    public function testCreatePersistor()
    {
        $client = $this->createMock(ClientInterface::class);
        $this->subject->setClient($client);

        $function = new \ReflectionMethod($this->subject, 'createPersistor');
        $function->setAccessible(true);
        $persistor = $function->invoke($this->subject);

        $this->assertInternalType('object', $persistor);
        $this->assertInstanceOf(Persistor::class, $persistor);
    }

    public function testCreatePersistorFailure()
    {
        // Set the client to null since it gets set in the above tests.
        $reflection = new \ReflectionClass(AbstractModel::class);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue(null);

        $function = new \ReflectionMethod($this->subject, 'createPersistor');
        $function->setAccessible(true);

        $this->expectException(ModelNotInitializedException::class);
        $persistor = $function->invoke($this->subject);
    }

    public function testToArray()
    {
        $this->assertInternalType('array', $this->subject->toArray());
    }
}
