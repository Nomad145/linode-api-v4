<?php

namespace LinodeApi\Model;

/**
 * Class Distribution
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Distribution extends AbstractModel
{
    protected $resource = 'distributions';

    public function getResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return sprintf('linode/%s', $this->getResource());
    }

    /**
     * {@inheritdoc}
     */
    public function getReference()
    {
        return sprintf('%s/%s', $this->endpoint, $this->id);
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceWithCommand(string $command)
    {
        return sprintf('%s/%s', $this->getReference(), $command);
    }
}
