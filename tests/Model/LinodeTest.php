<?php

namespace LinodeApi\Model\Test;

use GuzzleHttp\ClientInterface;
use LinodeApi\Exception\ModelOutOfSyncException;
use LinodeApi\Model\AbstractModel;
use LinodeApi\Model\Linode;
use LinodeApi\Model\Type;

/**
 * Class LinodeTest
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class LinodeTest extends \PHPUnit\Framework\TestCase
{
    public function testGetEndpoint()
    {
        $subject = new Linode();
        $this->assertSame('linode/instances', $subject->getEndpoint());
    }

    public function testGetResource()
    {
        $linode = Linode::newInstance($this->getJsonPayload());

        $this->assertSame('linode/instances/2020223', $linode->getResource());
    }

    public function testGetResourceOutOfSync()
    {
        $this->expectException(ModelOutOfSyncException::class);

        $linode = new Linode();
        $linode->getResource();
    }

    public function testNewInstance()
    {
        $subject = Linode::newInstance($payload = $this->getJsonPayload());

        $this->assertInternalType('object', $subject);
        $this->assertInstanceOf(Linode::class, $subject);
        $this->assertSame($payload['id'], $subject->id);
        $this->assertInternalType('object', $subject->type);
        $this->assertInstanceOf(Type::class, $subject->type);
        $this->assertSame($payload['type']['id'], $subject->type->id);
        $this->assertSame($payload['label'], $subject->label);
        $this->assertSame($payload['group'], $subject->group);
    }

    protected function getJsonPayload()
    {
        $payload = <<< EOF
{
    "alerts": {
        "cpu": {
            "enabled": true,
            "threshold": 90
        },
        "io": {
            "enabled": true,
            "threshold": 10000
        },
        "transfer_in": {
            "enabled": true,
            "threshold": 10
        },
        "transfer_out": {
            "enabled": true,
            "threshold": 10
        },
        "transfer_quota": {
            "enabled": true,
            "threshold": 80
        }
    },
    "backups": {
        "enabled": false,
        "schedule": {
            "day": null,
            "window": null
        }
    },
    "created": "2017-06-01T04:41:52",
    "distribution": null,
    "group": "Example",
    "hypervisor": "kvm",
    "id": 2020223,
    "ipv4": [
        "97.107.143.133"
    ],
    "ipv6": "2600:3c03::f03c:91ff:fe0a:43e0/64",
    "label": "linode2020223",
    "region": {
        "country": "us",
        "id": "us-east-1a",
        "label": "Newark, NJ"
    },
    "status": "provisioning",
    "total_transfer": 2000,
    "type": {
        "backups_price": 2.5,
        "class": "standard",
        "hourly_price": 0.015,
        "id": "g5-standard-1",
        "label": "Linode 2048",
        "mbits_out": 1000,
        "monthly_price": 10.0,
        "ram": 2048,
        "storage": 30720,
        "transfer": 2000,
        "vcpus": 1
    },
    "updated": "2017-06-01T04:41:52"
}
EOF;

        return json_decode($payload, true);
    }
}
