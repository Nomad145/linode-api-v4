<?php

namespace LinodeApi\Model\Test;

use GuzzleHttp\ClientInterface;
use LinodeApi\Model\Linode;
use LinodeApi\Model\AbstractModel;

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
}
