<?php

namespace LinodeApi\Model;

use LinodeApi\Model\AbstractModel;

/**
 * Class Type
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Type extends AbstractModel
{
    protected $endpoint = 'linode/types';

    protected $fillable = [
        'id',
    ];

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getResource()
    {
        return sprintf('%s/%s', $this->getEndpoint, $this->id);
    }
}
