<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait BusinessUnitUuid
 */
trait BusinessUnitUuid
{
    /**
     * Set businessUnit uuid
     *
     * @param string $businessUnitUuid
     * @return object
     */
    public function setBusinessUnitUuid($businessUnitUuid)
    {
        $this->businessUnitUuid = $businessUnitUuid;

        return $this;
    }

    /**
     * Get businessUnit uuid
     *
     * @return string
     */
    public function getBusinessUnitUuid()
    {
        return $this->businessUnitUuid;
    }
}
