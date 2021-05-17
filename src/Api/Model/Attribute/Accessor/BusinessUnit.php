<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\BusinessUnit as BusinessUnitModel;

/**
 * Trait BusinessUnit
 *
 * @package Ds\Component\Api
 */
trait BusinessUnit
{
    /**
     * Set business unit
     *
     * @param \Ds\Component\Api\Model\BusinessUnit $businessUnit
     * @return object
     */
    public function setBusinessUnit(?BusinessUnitModel $businessUnit)
    {
        $this->businessUnit = $businessUnit;

        return $this;
    }

    /**
     * Get business unit
     *
     * @return \Ds\Component\Api\Model\BusinessUnit
     */
    public function getBusinessUnit(): ?BusinessUnitModel
    {
        return $this->businessUnit;
    }
}
