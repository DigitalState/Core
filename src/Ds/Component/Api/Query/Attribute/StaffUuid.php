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
    protected $staffUuid; # region accessors

    /**
     * Set staff uuid
     *
     * @param string $staffUuid
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setStaffUuid($staffUuid)
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
    public function getStaffUuid()
    {
        return $this->staffUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_staffUuid;
}
