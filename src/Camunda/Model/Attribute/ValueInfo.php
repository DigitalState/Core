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
    private $valueInfo; # region accessors

    /**
     * Set valueInfo
     *
     * @param \stdClass $valueInfo
     * @return object
     */
    public function setValueInfo(?stdClass $valueInfo)
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
    public function getValueInfo(): ?stdClass
    {
        return $this->valueInfo;
    }

    # endregion
}
