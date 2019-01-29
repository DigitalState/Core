<?php

namespace Ds\Component\Statistic\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Model\Attribute;
use stdClass;

/**
 * Class Data
 *
 * @package Ds\Component\Statistic
 */
final class Data
{
    use Attribute\Collection;
    use Attribute\Timestamp;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new DateTime;
        $this->collection = new ArrayCollection;
    }

    /**
     * Type cast to object
     *
     * @return \stdClass
     */
    public function toObject(): stdClass
    {
        $object = new stdClass;
        $object->timestamp = $this->timestamp;
        $object->collection = $this->collection->toArray();

        foreach ($object->collection as $alias => $status) {
            $object->collection[$alias] = $status->toObject();
        }

        return $object;
    }
}
