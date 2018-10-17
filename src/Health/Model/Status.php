<?php

namespace Ds\Component\Health\Model;

use DateTime;
use Ds\Component\Health\Model\Attribute as HealthAttribute;
use Ds\Component\Model\Attribute;

/**
 * Class Status
 *
 * @package Ds\Component\Health
 */
class Status
{
    use Attribute\Alias;
    use HealthAttribute\Healthy;
    use Attribute\Timestamp;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->healthy = false;
        $this->timestamp = new DateTime;
    }

    /**
     * Type cast to object
     *
     * @return \stdClass
     */
    public function toObject()
    {
        return (object) get_object_vars($this);
    }
}
