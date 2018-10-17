<?php

namespace Ds\Component\Camunda\Model\Attribute;

use stdClass;

/**
 * Trait ValueInfo
 *
 * @package Ds\Component\Camunda
 */
trait ValueInfo
{
    /**
     * @var \stdClass
     */
    protected $valueInfo; # region accessors

    /**
     * Set valueInfo
     *
     * @param \stdClass $valueInfo
     * @return object
     */
    public function setValueInfo(stdClass $valueInfo = null)
    {
        if (null === $valueInfo) {
            $valueInfo = new stdClass;
        }

        $this->valueInfo = $valueInfo;

        return $this;
    }

    /**
     * Get valueInfo
     *
     * @return \stdClass
     */
    public function getValueInfo()
    {
        return $this->valueInfo;
    }

    # endregion
}
