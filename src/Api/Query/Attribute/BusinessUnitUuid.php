<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait BusinessUnitUuid
 *
 * @package Ds\Component\Api
 */
trait BusinessUnitUuid
{
    /**
     * @var string
     */
    private $businessUnitUuid; # region accessors

    /**
     * Set business unit uuid
     *
     * @param string $businessUnitUuid
     * @return object
     */
    public function setBusinessUnitUuid(?string $businessUnitUuid)
    {
        $this->businessUnitUuid = $businessUnitUuid;
        $this->_businessUnitUuid = true;

        return $this;
    }

    /**
     * Get business unit uuid
     *
     * @return string
     */
    public function getBusinessUnitUuid(): ?string
    {
        return $this->businessUnitUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_businessUnitUuid;
}
