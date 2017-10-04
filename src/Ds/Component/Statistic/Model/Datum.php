<?php

namespace Ds\Component\Statistic\Model;

use DateTime;
use Ds\Component\Model\Attribute;

/**
 * Class Datum
 *
 * @package Ds\Component\Statistic
 */
class Datum
{
    use Attribute\Alias;
    use Attribute\Value;
    use Attribute\Timestamp;

    /**
     * Constructor
     */
    public function __construct()
    {
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
