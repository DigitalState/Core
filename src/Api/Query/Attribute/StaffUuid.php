<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait StaffUuid
 *
 * @package Ds\Component\Api
 */
trait StaffUuid
{
    /**
     * @var string
     */
    private $staffUuid; # region accessors

    /**
     * Set staff uuid
     *
     * @param string $staffUuid
     * @return object
     */
    public function setStaffUuid(?string $staffUuid)
    {
        $this->staffUuid = $staffUuid;
        $this->_staffUuid = true;

        return $this;
    }

    /**
     * Get staff uuid
     *
     * @return string
     */
    public function getStaffUuid(): ?string
    {
        return $this->staffUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_staffUuid;
}
