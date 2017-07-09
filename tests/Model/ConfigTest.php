<?php

namespace LinodeApi\Model\Test;

use LinodeApi\Exception\ModelOutOfSyncException;
use LinodeApi\Model\Config;
use LinodeApi\Model\Linode;

/**
 * Class ConfigTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class ConfigTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->linode = Linode::newInstance(['id' => 1]);
    }

    public function testGetResource()
    {
        $config = new Config($this->linode);
        $config->hydrate(['id' => 1]);

        $linode = new Linode();
        $linode->hydrate(['id' => 1]);

        $config->linode = $linode;

        $this->assertSame('linode/instances/1/configs/1', $config->getResource());
        /* $this->assertSame('linode/instances/1/configs/1/command', $config->getReferenceWithCommand('command')); */
    }

    public function testGetResourceOutOfSync()
    {
        $this->expectException(ModelOutOfSyncException::class);

        $config = new Config($this->linode);
        $config->getResource();
    }
}
