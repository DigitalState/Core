<?php

namespace Ds\Component\Health\Model;

use Doctrine\Common\Collections\ArrayCollection;
use stdClass;

/**
 * Class Statuses
 *
 * @package Ds\Component\Health
 */
class Statuses
{
    use Attribute\Healthy;
    use Attribute\Collection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->healthy = false;
        $this->collection = new ArrayCollection;
    }

    /**
     * Type cast to object
     *
     * @return \stdClass
     */
    public function toObject()
    {
        $object = new stdClass;
        $object->healthy = $this->healthy;
        $object->collection = $this->collection->toArray();

        foreach ($object->collection as $alias => $status) {
            $object->collection[$alias] = $status->toObject();
        }

        return $object;
    }
}
