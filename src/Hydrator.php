<?php

namespace LinodeApi;

use LinodeApi\Collection\ModelCollection;
use LinodeApi\Model\AbstractModel;

/**
 * Class Hydrator
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Hydrator
{
    public function hydrateCollection(AbstractModel $model, array $collection)
    {
        return new ModelCollection(
            array_map(function (array $linode) use ($model) {
                return $model::newInstance($linode);
            }, $collection)
        );
    }
}
