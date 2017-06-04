<?php

namespace LinodeApi\Request;

use GuzzleHttp\ClientInterface;
use LinodeApi\Request\RequestBuilder;
use LinodeApi\Model\AbstractModel;

/**
 * Class Processor
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Processor
{
    public function __construct(ClientInterface $client, RequestBuilder $builder)
    {
        $this->client = $client;
        $this->builder = $builder;
    }

    public function create(AbstractModel $model)
    {
        $request = $this->builder
            ->setMethod('POST')
            ->setUri($model->getEndpoint())
            ->setBody($model->toArray())
            ->build();

        return $this->client->send($request);
    }

    public function find(AbstractModel $model)
    {
        $request = $this->builder
            ->setMethod('GET')
            ->setUri($model->getEndpoint())
            ->build();

        $response = json_decode($this->client->send($request)->getBody(), true);

        return $model->setAttributes($response);
    }

    public function update(AbstractModel $model)
    {
    }

    public function delete(AbstractModel $model)
    {
        $request = $this->builder
            ->setMethod('DELETE')
            ->setUri(sprintf('%s/%s', $model->getEndpoint(), $model->getId()))
            ->build();

        return $this->client->send($request);
    }
}
