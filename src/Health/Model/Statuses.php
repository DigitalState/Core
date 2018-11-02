<?php

namespace Ds\Component\Health\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Health\Model\Attribute as HealthAttribute;
use Ds\Component\Model\Attribute;
use stdClass;

/**
 * Class Statuses
 *
 * @package Ds\Component\Health
 */
class Statuses
{
    use HealthAttribute\Healthy;
    use Attribute\Collection;
    use Attribute\Timestamp;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->healthy = false;
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
        $object->healthy = $this->healthy;
        $object->timestamp = $this->timestamp;
        $object->collection = $this->collection->toArray();

        foreach ($object->collection as $alias => $status) {
            $object->collection[$alias] = $status->toObject();
        }

        return $object;
    }
}
