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
abstract class AbstractModel
{
    /**
     * @var ClientInterface
     *
     * The HTTP Client communicating with the API.
     */
    protected static $client;

    /**
     * @var boolean
     *
     * The state of the model relating to source data; true if data has
     * been modified.
     */
    protected $dirty = false;

    /**
     * @var boolean
     */
    protected $synced = false;

    /** @var array */
    protected $attributes = [];

    /**
     * setClient
     *
     * Set the HTTP Guzzle Client.
     *
     * @param ClientInterface
     */
    public static function setClient(ClientInterface $client)
    {
        static::$client = $client;
    }

    /**
     * setAttributes
     *
     * How do we enforce that the API is the only thing that hydrates the
     * model?  In what scenarios would a developer need this method?
     *  - Hydrating the model from a cached response.
     *
     * @param array $attributes
     * @param bool $sync Flag for setting the model to 'synced'.
     */
    public function setAttributes(array $attributes, bool $sync = true)
    {
        $this->attributes = $attributes;

        if ($sync) {
            $this->sync();
        }

        return $this;
    }

    protected function sync()
    {
        $this->synced = true;
        $this->isDirty = false;
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        if ($this->synced) {
            $this->dirty = true;
        }

        return $this;
    }

    public function getAttribute($attribute)
    {
        // @TODO: Error handling.
        //  - What happens when an attribute doesn't exist?
        return $this->attributes[$attribute];
    }

    /**
     * getResource
     *
     * Returns the base name of the object.
     *
     * @return string
     */
    abstract public function getResource();

    /**
     * getEndpoint
     *
     * Returns the API endpoint for the model excluding the object's
     * identifier.  Associations implementing this method often need the id of
     * the owning object in the URI.
     *
     * @return string
     */
    abstract public function getEndpoint();

    /**
     * getBaseUrl
     *
     * Returns the endpoint for the model with it's identifier.
     *
     * @return string
     */
    abstract public function getReference();

    /**
     * getBaseUrlWithCommand
     *
     * Returns the endpoing for the model with a command.
     *
     * @param string $command
     * @return string
     */
    abstract public function getReferenceWithCommand(string $command);

    /**
     * createPersistor
     *
     * @return Persistor
     */
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

    /**
     * newInstance
     *
     * Create a new instance of the model, optionally hydrating it.
     * @FIXME: Does this need to be abstract?
     *
     * @param array $attributes
     * @return static
     */
    public function newInstance(array $attributes = [])
    {
        $model = new static;
        $model->hydrate($attributes);

        return $model;
    }

    /**
     * hydrate
     *
     * The method responsible for hydrating the model data.
     *
     * @param array
     * @return static
     */
    abstract protected function hydrate(array $attributes);

    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * __call
     *
     * Execute any public static method on a new instance.
     */
    public static function __call($method, $arguments)
    {
        $model = new static;

        return $model->$method($arguments);
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
