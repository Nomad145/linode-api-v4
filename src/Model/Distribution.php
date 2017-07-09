<?php

namespace LinodeApi\Model;

/**
 * Class Distribution
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Distribution extends AbstractModel
{
    protected $endpoint = 'linode/distributions';

    protected $fillable = [
        'id',
        'created',
        'label',
        'minimumStorageSize',
        'deprecated',
        'vendor',
        'x64'
    ];

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getResource()
    {
        sprintf('%s/%s', $this->getEndpoint(), $this->getId());
    }
}
