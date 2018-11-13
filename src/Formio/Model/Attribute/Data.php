<?php

namespace Ds\Component\Formio\Model\Attribute;

use stdClass;

/**
 * Trait Data
 *
 * @package Ds\Component\Formio
 */
trait Data
{
    /**
     * @var \stdClass
     */
    private $data; # region accessors

    /**
     * Set data
     *
     * @param stdClass $data
     * @return object
     */
    public function setData(stdClass $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return stdClass
     */
    public function getData(): stdClass
    {
        return $this->data;
    }

    # endregion
}
