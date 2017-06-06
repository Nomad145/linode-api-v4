<?php

namespace LinodeApi;

use Doctrine\Common\Collections\ArrayCollection;
use LinodeApi\Model\AbstractModel;

/**
 * Class Hydrator
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class Hydrator
{
    public function hydrateCollection(AbstractModel $model, array $collection)
    {
        return new ArrayCollection(
            array_map(function (array $linode) use ($model) {
                return $model
                    ->newInstance()
                    ->setAttributes($linode);
            }, $collection)
        );
    }
}
