<?php

namespace LinodeApi\Model;

use GuzzleHttp\Psr7\Request;
use LinodeApi\Exception\ModelOutOfSyncException;
use LinodeApi\Model\AbstractModel;

/**
 * Class Linode
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Linode extends AbstractModel
{
    protected $resource = 'instances';

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
        if (!$this->synced) {
            throw new ModelOutOfSyncException('Object is out of sync.');
        }

        return sprintf('%s/%s', $this->getEndpoint(), $this->id);
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceWithCommand(string $command)
    {
        if (!$this->synced) {
            throw new ModelOutOfSyncException('Object is out of sync.');
        }

        return sprintf('%s/%s', $this->getReference(), $command);
    }

    /**
     * boot
     *
     * Boot a Linode.  The Linode must first have a configuration.
     */
    public function boot()
    {
        self::$client->post($this->getReferenceWithCommand('boot'));

        return $this;
    }

    public function getConfigs()
    {
        /* $this->configs = (new ModelFactory()) */
        /*     ->create( */
        /*         Configs::class, */
        /*         json_encode(self::$client->get(sprintf('%s/%s/configs', $this->endpoint, $this->id))) */
        /*     ); */

        $persistor = $this->createPersistor();

        $this->configs = $persistor->findMany(new Config());
    }

    public function addConfig(Config $config)
    {
        $request = new Request('POST', sprintf('%s/%s/config'), $config->toArray());
        self::$client->send($request);

        return $this;
    }
}
