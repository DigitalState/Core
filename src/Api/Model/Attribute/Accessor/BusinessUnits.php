<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

/**
 * Trait BusinessUnits
 *
 * @package Ds\Component\Api
 */
trait BusinessUnits
{
    /**
     * Set business units
     *
     * @param array $businessUnits
     * @return object
     */
    public function setBusinessUnits(array $businessUnits)
    {
        $this->businessUnits = $businessUnits;

        return $this;
    }

    /**
     * Get business units
     *
     * @return array
     */
    public function getBusinessUnits(): array
    {
        return $this->businessUnits;
    }
}
