<?php

namespace LinodeApi\Test;

use LinodeApi\Hydrator;
use LinodeApi\Model\Linode;
use Doctrine\Common\Collections\ArrayCollection;

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
        $collection = $subject->hydrateCollection($model, [['a' => 1]]);

        $this->assertInternalType('object', $collection);
        $this->assertInstanceOf(ArrayCollection::class, $collection);
        $this->assertInternalType('object', $linode = $collection->first());
        $this->assertInstanceOf(Linode::class, $linode);
        $this->assertSame(1, $linode->getAttribute('a'));
    }
}
