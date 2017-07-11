<?php

namespace LinodeApi\Request;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;
use LinodeApi\Model\AbstractModel;
use LinodeApi\Exception\PersistenceException;
use LinodeApi\Hydrator;

/**
 * Class Persistor
 *
 * @TODO: These methods should always receive a clone of the model for
 * immutibility.
 *
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Persistor
{
    public function __construct(ClientInterface $client, RequestBuilder $builder, Hydrator $hydrator)
    {
        $this->client = $client;
        $this->builder = $builder;
        $this->hydrator = $hydrator;
    }

    public function create(AbstractModel $model)
    {
        $request = $this->builder
            ->setMethod('POST')
            ->setUri($model->getEndpoint())
            ->setBody($model->toArray())
            ->build();

        $response = json_decode($this->client->send($request)->getBody(), true);

        return $model::newInstance($response);
    }

    public function findOne(AbstractModel $model, int $id)
    {
        $request = $this->builder
            ->setMethod('GET')
            ->setUri(sprintf('%s/%s', $model->getEndpoint(), $id))
            ->build();

        $response = json_decode($this->client->send($request)->getBody(), true);

        return $model::newInstance($response);
    }

    /**
     * findMany
     *
     * @param AbstractModel $model
     * @return ArrayCollection|AbstractModel
     */
    public function findMany(AbstractModel $model)
    {
        $request = $this->build('GET', $model->getEndpoint());
        $response = json_decode($this->client->send($request)->getBody(), true);
        $collection = $this->hydrator->hydrateCollection($model, $response['linodes']);

        // @FIXME: Basic demonstration of pagination.
        /* return $this->hydrator->hydrateCollection($model, $response[$model->getResource()]); */
        for ($i = $response['page'] + 1; $i <= $response['total_pages']; $i++) {
            $request = $this->build('GET', $model->getEndpoint() . "?page=$i");
            $response = json_decode($this->client->send($request)->getBody(), true);
            $collection = $collection->merge(
                $this->hydrator->hydrateCollection($model, $response['linodes'])
            );
        }

        return $collection;
    }

    private function build($method, $uri)
    {
        return $this->builder
            ->setMethod($method)
            ->setUri($uri)
            ->build();
    }

    public function update(AbstractModel $model)
    {
        $request = $this->builder
            ->setMethod('PUT')
            ->setUri($model->getResource())
            ->setBody($model->toArray())
            ->build();

        return $this->client->send($request);
    }

    public function delete(AbstractModel $model)
    {
        if (!$model->id) {
            throw new PersistenceException(sprintf('Cannot delete unpersisted object of class %s', get_class($model)));
        }

        $request = $this->builder
            ->setMethod('DELETE')
            ->setUri($model->getResource())
            ->build();

        // @TODO: Error handling.
        $this->client->send($request);
    }
}
