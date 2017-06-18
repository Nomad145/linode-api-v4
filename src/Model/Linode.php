<?php

namespace LinodeApi\Model;

use GuzzleHttp\Psr7\Request;
use LinodeApi\Model\AbstractModel;

/**
 * Class Linode
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Linode extends AbstractModel
{
    protected $endpoint = 'linode/instances';

    /**
     * {@inheritdoc}
     */
    public function getBaseUrl()
    {
        return sprintf('%s/%s', $this->endpoint, $this->id);
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseUrlWithCommand(string $command)
    {
        return sprintf('%s/%s', $this->getBaseUrl(), $command);
    }

    /**
     * boot
     *
     * Boot a Linode.  The Linode must first have a configuration.
     */
    public function boot()
    {
        self::$client->post(sprintf('%s/%s/boot', $this->endpoint, $this->id));

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
