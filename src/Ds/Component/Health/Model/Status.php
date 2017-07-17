<?php

namespace Ds\Component\Health\Model;

/**
 * Class Status
 *
 * @package Ds\Component\Health
 */
class Status
{
    use Attribute\Alias;
    use Attribute\Healthy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->healthy = false;
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
