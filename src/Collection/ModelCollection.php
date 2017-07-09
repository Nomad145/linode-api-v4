<?php

namespace LinodeApi\Collection;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ModelCollection
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class ModelCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     *
     * Lazy load additional pages.
     */
    public function merge(ModelCollection $collection) : ModelCollection
    {
        return new self(
            array_merge($this->toArray(), $collection->toArray())
        );
    }
}
