<?php

namespace LinodeApi\Model;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;
use LinodeApi\Request\Processor;

/**
 * Class AbstractModel
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class AbstractModel
{
    protected static $client;

    protected $isDirty = false;

    protected $attributes = [];

    public static function setClient(ClientInterface $client)
    {
        static::$client = $client;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    protected function createProcessor()
    {
        return new Processor(static::$client, new RequestBuilder());
    }

    public function save()
    {
        $processor = $this->createProcessor();

        return $this->isDirty ? $processor->update($this) : $processor->create($this);
    }

    public function delete()
    {
        $processor = $this->createProcessor();
        $processor->delete($this);

        return $this;
    }

    public static function find($id)
    {
        $processor = new Processor(static::$client, new RequestBuilder());
        return $processor->find((new static), $id);
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
