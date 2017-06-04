<?php

namespace LinodeApi\Model;

use LinodeApi\Model\AbstractModel;

/**
 * Class Linode
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Linode extends AbstractModel
{
    protected $endpoint = 'linode/instances';

    public function __construct()
    {
        $this->attributes = [
            'region' => 'us-east-1a',
            'type' => 'g5-standard-1'
        ];
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}
