<?php

namespace LinodeApi\Model;

use GuzzleHttp\ClientInterface;
use LinodeApi\Model\AbstractModel;
use LinodeApi\Model\Linode;

/**
 * Class Disk
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Disk extends AbstractModel
{
    /** @var string */
    protected $endpoint = 'linode/instances/%s/disks';

    /** @var Linode */
    protected $linode;

    public function __construct(Linode $linode)
    {
        $this->linode = $linode;
    }

    public function getEndpoint()
    {
        return sprintf($this->endpoint, $this->linode->id);
    }

    public function getReference()
    {
        if (!$this->synced) {
            throw new ModelOutOfSyncException('Object is out of sync.');
        }

        return sprintf('%s/disks/%s', $this->linode->getReference(), $this->id);
    }

    public function getReferenceWithCommand(string $command)
    {
        if (!$this->synced) {
            throw new ModelOutOfSyncException('Object is out of sync.');
        }

        return sprintf('%s/%s', $this->getReference(), $command);
    }
}
