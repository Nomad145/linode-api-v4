<?php

namespace LinodeApi\Test;

use LinodeApi\Collection\ModelCollection;
use LinodeApi\Hydrator;
use LinodeApi\Model\Linode;

/**
 * Class HydratorTest
 * @author Michael Phillips <michael.phillips@manpow.com>
 */
class HydratorTest extends \PHPUnit\Framework\TestCase
{
    public function testHydrateCollection()
    {
        $subject = new Hydrator();
        $model = new Linode();
        $collection = $subject->hydrateCollection($model, [['id' => 1]]);

        $this->assertInternalType('object', $collection);
        $this->assertInstanceOf(ModelCollection::class, $collection);
        $this->assertInternalType('object', $linode = $collection->first());
        $this->assertInstanceOf(Linode::class, $linode);
        $this->assertSame(1, $linode->id = 1);
    }
}
