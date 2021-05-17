<?php

namespace Ds\Component\Security\Model\Attribute\Accessor;

/**
 * Trait BusinessUnits
 *
 * @package Ds\Component\Security
 */
trait BusinessUnits
{
    /**
     * Set business units
     *
     * @param array $businessUnits
     * @return object
     * @throws \InvalidArgumentException
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
