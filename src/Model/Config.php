<?php

namespace LinodeApi\Model;

use LinodeApi\Exception\ModelOutOfSyncException;

/**
 * Class Config
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Config extends AbstractModel
{
    /** @var string */
    protected $endpoint = 'linode/instances/%s/configs';

    /** @var Linode */
    public $linode;

    /** @var array */
    public $disks = [];

    public function __construct(Linode $linode)
    {
        $this->linode = $linode;
    }

    public function getEndpoint()
    {
        return sprintf($this->endpoint, $this->linode->id);
    }

    public function getResource()
    {
        return 'config';
    }

    public function getReference()
    {
        if (!$this->synced) {
            throw new ModelOutOfSyncException('Object is out of sync.');
        }

        return sprintf('%s/configs/%s', $this->linode->getReference(), $this->id);
    }

    public function getReferenceWithCommand(string $command)
    {
        if (!$this->synced) {
            throw new ModelOutOfSyncException('Object is out of sync.');
        }

        return sprintf('%s/%s', $this->getReference(), $command);
    }

    /**
     * addDisk
     *
     * @param string $label
     * @param Disk $disk
     */
    public function addDisk(string $label, Disk $disk)
    {
        $this->disks[$label] = $disk;
    }

    public function toArray()
    {
        return array_merge($this->attributes, [
            'disks' => array_map(
                function (Disk $disk) {
                    return $disk->id;
                },
                $this->disks
            )
        ]);
    }
}
