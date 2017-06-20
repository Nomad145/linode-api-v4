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
    public function testGetReference()
    {
        $config = new Config();
        $config->setAttributes(['id' => 1]);

        $linode = new Linode();
        $linode->setAttributes(['id' => 1]);

        $config->linode = $linode;

        $this->assertSame('linode/instances/1/configs/1', $config->getReference());
        $this->assertSame('linode/instances/1/configs/1/command', $config->getReferenceWithCommand('command'));
    }

    public function testGetReferenceOutOfSync()
    {
        $this->expectException(ModelOutOfSyncException::class);

        $config = new Config();
        $config->getReference();
    }

    public function testGetReferenceWithCommandOutOfSync()
    {
        $this->expectException(ModelOutOfSyncException::class);

        $config = new Config();
        $config->getReferenceWithCommand('command');
    }
}
