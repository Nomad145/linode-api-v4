<?php

namespace LinodeApi\Request\Test;

use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use LinodeApi\Exception\PersistenceException;
use LinodeApi\Hydrator;
use LinodeApi\Model\Linode;
use LinodeApi\Request\Persistor;
use LinodeApi\Request\RequestBuilder;

/**
 * Class PersistorTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class PersistorTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->client = $this->createMock(ClientInterface::class);
        $builder = new RequestBuilder();
        $hydrator = new Hydrator();

        $this->subject = new Persistor($this->client, $builder, $hydrator);
    }

    public function testCreate()
    {
        $request = $this->createMock(Request::class);
        $model = new Linode();

        $request->expects($this->any())
            ->method('getBody')
            ->willReturn('{"id": 1}');

        $this->client->expects($this->once())
            ->method('send')
            ->willReturn($request);

        $linode = $this->subject->create($model);

        $this->assertInternalType('object', $linode);
        $this->assertInstanceOf(Linode::class, $linode);
        $this->assertSame(1, $linode->id);
    }

    public function testDelete()
    {
        $model = new Linode();
        $model->hydrate(['id' => 1]);

        $this->assertNull($this->subject->delete($model));
    }

    public function testDeleteModelWithNoId()
    {
        $this->expectException(PersistenceException::class);

        $model = $this->createMock(Linode::class);
        $this->subject->delete($model);
    }

    public function testFindOne()
    {
        $request = $this->createMock(Request::class);

        $request->expects($this->any())
            ->method('getBody')
            ->willReturn('{"id": 1}');

        $this->client->expects($this->once())
            ->method('send')
            ->willReturn($request);

        $linode = $this->subject->findOne(new Linode(), 1);

        $this->assertInternalType('object', $linode);
        $this->assertInstanceOf(Linode::class, $linode);
        $this->assertSame(1, $linode->id);
    }

    public function testFindMany()
    {
        $apiResponse = $this->createMock(Request::class);

        $apiResponse->expects($this->any())
            ->method('getBody')
            ->will($this->onConsecutiveCalls(
                '{"page": 1, "page_total": 3, "linodes": [{ "id": 1 }]}',
                '{"page": 2, "page_total": 3, "linodes": [{ "id": 2 }]}',
                '{"page": 3, "page_total": 3, "linodes": [{ "id": 3 }]}'
            ));

        $this->client->expects($this->any())
            ->method('send')
            ->willReturn($apiResponse);

        $linodes = $this->subject->findMany(new Linode());

        $this->assertInternalType('object', $linodes);
        $this->assertInstanceOf(ArrayCollection::class, $linodes);
        $this->assertNotEmpty($linodes);
        $this->assertCount(3, $linodes);
        $this->assertInstanceOf(Linode::class, $linode = $linodes->first());
        $this->assertSame(1, $linode->id);
    }
}
