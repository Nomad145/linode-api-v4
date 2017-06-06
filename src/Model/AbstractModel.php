<?php

namespace LinodeApi\Model;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;
use LinodeApi\Request\Persistor;
use LinodeApi\Exception\ModelNotInitializedException;
use LinodeApi\Hydrator;

/**
 * Class AbstractModel
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class AbstractModel
{
    /** @var ClientInterface */
    protected static $client;

    /** @var boolean */
    protected $isDirty = false;

    /** @var boolean */
    protected $synced = false;

    /** @var array */
    protected $attributes = [];

    /**
     * setClient
     *
     * Sets the HTTP Guzzle Client on the base class.
     *
     * @param ClientInterface
     */
    public static function setClient(ClientInterface $client)
    {
        static::$client = $client;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        $this->isDirty = false;

        return $this;
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        $this->setDirty();

        return $this;
    }

    protected function setDirty()
    {
        if ($this->synced) {
            $this->dirty = true;
        }

        return $this;
    }

    public function getAttribute($attribute)
    {
        // @TODO: Error handling.
        return $this->attributes[$attribute];
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

        /*
         * @TODO: Executing the request should be delegated to another class.
         *
         * $builder
         *     ->setUri()
         *     ->setBody()
         *     ->execute();
         */
        return new Persistor(static::$client, new RequestBuilder(), new Hydrator());
    }

    public function save()
    {
        $persistor = $this->createPersistor();

        return $this->isDirty ? $persistor->update($this) : $persistor->create($this);
    }

    public function delete()
    {
        $this->createPersistor()->delete($this);
    }

    public static function find($id)
    {
        $model = (new static);

        return $model->createPersistor()->findOne($model, $id);
    }

    public static function all()
    {
        $model = new static;

        return $model->createPersistor()->findMany($model);
    }

    public function newInstance()
    {
        return new static;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function __set($attribute, $value)
    {
        $this->setAttribute($attribute, $value);

        return $this;
    }

    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }
}
