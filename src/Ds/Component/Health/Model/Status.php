<?php

namespace Ds\Component\Health\Model;

use DateTime;

/**
 * Class Status
 *
 * @package Ds\Component\Health
 */
class Status
{
    use Attribute\Alias;
    use Attribute\Healthy;
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
