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
    protected const ASSOCIATION_MAP = [];

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
     * getResource
     *
     * Returns the resource for the model with it's identifier.
     *
     * @return string
     */
    abstract public function getResource();

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
     * setAttributes
     *
     * How do we enforce that the API is the only thing that hydrates the
     * model?  In what scenarios would a developer need this method?
     *  - Hydrating the model from a cached response.
     *
     * @param array $attributes
     * @param bool $sync Flag for setting the model to 'synced'.
     */
    protected function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * getPersistor
     *
     * @return Persistor
     */
    protected function getPersistor()
    {
        if (!static::$client) {
            throw new ModelNotInitializedException('The HTTP client was not initialized.');
        }

        return new Persistor(static::$client, new RequestBuilder(), new Hydrator());
    }

    public function save()
    {
        $persistor = $this->getPersistor();

        return $this->isDirty ? $persistor->update($this) : $persistor->create($this);
    }

    public function delete()
    {
        $this->getPersistor()->delete($this);
    }

    public static function find($id)
    {
        $model = (new static);

        return $model->getPersistor()->findOne($model, $id);
    }

    public static function all()
    {
        $model = new static;

        return $model->getPersistor()->findMany($model);
    }

    public function hydrate(array $attributes)
    {
        // Set the class property within the local scope for array_* functions.
        $fillable = $this->fillable;

        // Set the filtered attributes on the class.
        $this->setAttributes(
            array_filter(
                $attributes,
                function ($value, $key) use ($fillable) {
                    /* @var $this ->fillable */
                    return in_array($key, $fillable);
                },
                ARRAY_FILTER_USE_BOTH
            )
        );

        $this->hydrateAssociations();
    }

    /**
     * hydrate
     *
     * The method responsible for hydrating the model data.
     *
     * @param array
     * @return static
     */
    protected function hydrateAssociations()
    {
        $associations = array_filter(
            $this->attributes,
            function ($value, $key) {
                return $value != null && in_array($key, array_values(array_keys(static::ASSOCIATION_MAP)));
            },
            ARRAY_FILTER_USE_BOTH
        );

        array_walk(
            $associations,
            function (&$value, $key) {
                $value = static::ASSOCIATION_MAP[$key]::newInstance($value);
            }
        );

        $this->setAttributes(array_merge($this->attributes, $associations));
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
     * @TODO: Replace with serialization groups.
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * __callStatic
     */
    public static function __callStatic($method, $arguments)
    {
        return (new static)->$method(...$arguments);
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
