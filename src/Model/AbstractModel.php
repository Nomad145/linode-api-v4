<?php

namespace LinodeApi\Model;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;
use LinodeApi\Request\Persistor;
use LinodeApi\Exception\ModelNotInitializedException;

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

    protected function createPersistor()
    {
        if (!static::$client) {
            throw new ModelNotInitializedException('The HTTP client was not initialized.');
        }

        return new Persistor(static::$client, new RequestBuilder());
    }

    public function save()
    {
        $persistor = $this->createPersistor();

        return $this->isDirty ? $persistor->update($this) : $persistor->create($this);
    }

    public function delete()
    {
        return $this->createPersistor()->delete($this);
    }

    public static function find($id)
    {
        return (new static)->createPersistor()->find($model, $id);
    }

    public function toArray()
    {
        return $this->attributes;
    }
}
