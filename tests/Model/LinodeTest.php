<?php

namespace LinodeApi\Model\Test;

use GuzzleHttp\ClientInterface;
use LinodeApi\Exception\ModelOutOfSyncException;
use LinodeApi\Model\AbstractModel;
use LinodeApi\Model\Linode;

/**
 * Class LinodeTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class LinodeTest extends \PHPUnit\Framework\TestCase
{
    public function testLinode()
    {
        $client = $this->createMock(ClientInterface::class);
        AbstractModel::setClient($client);

        $linode = new Linode();

        $this->markTestIncomplete('To be continued...');
    }

    public function testGetEndpoint()
    {
        $subject = new Linode();
        $this->assertSame('linode/instances', $subject->getEndpoint());
    }

    public function testBoot()
    {
        $client = $this->createMock(ClientInterface::class);
        $client->method('post')
            ->willReturn('{}');

        $this->markTestIncomplete('To be continued...');
    }

    public function testGetReference()
    {
        $linode = new Linode();
        $linode->setAttributes(['id' => 1]);

        $this->assertSame('linode/instances/1', $linode->getReference());
        $this->assertSame('linode/instances/1/boot', $linode->getReferenceWithCommand('boot'));
    }

    public function testGetReferenceOutOfSync()
    {
        $this->expectException(ModelOutOfSyncException::class);

        $linode = new Linode();
        $linode->getReference();
    }
}
