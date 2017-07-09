<?php

namespace LinodeApi\Model;

use GuzzleHttp\Psr7\Request;
use LinodeApi\Exception\ModelOutOfSyncException;
use LinodeApi\Model\AbstractModel;
use LinodeApi\Model\Region;
use LinodeApi\Model\Type;

/**
 * Class Linode
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Linode extends AbstractModel
{
    protected const ASSOCIATION_MAP = [
        'type' => Type::class,
        'distribution' => Distribution::class
    ];

    protected $endpoint = 'linode/instances';

    protected $fillable = [
        'id',
        'region',
        'type',
        'label',
        'group',
        'distribution',
        'rootPass',
        'rootSshKey',
        'stackScript',
        'stackScriptData',
        'backup',
        'withBackup'
    ];

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        if (!$this->id) {
            throw new ModelOutOfSyncException('Object is out of sync, therefore does not have a resource.');
        }

        return sprintf('%s/%s', $this->getEndpoint(), $this->id);
    }

    /**
     * boot
     *
     * Boot a Linode.  The Linode must first have a configuration.
     */
    public function boot()
    {
        self::$client->post(sprintf('%s/%s', $this->getResource(), 'boot'));

        return $this;
    }
}
