<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait OrganizationUuid
 *
 * @package Ds\Component\Api
 */
trait OrganizationUuid
{
    /**
     * @var string
     */
    protected $organizationUuid; # region accessors

    /**
     * Set organization uuid
     *
     * @param string $organizationUuid
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setOrganizationUuid($organizationUuid)
    {
        $this->organizationUuid = $organizationUuid;
        $this->_organizationUuid = true;

        return $this;
    }

    /**
     * Get organization uuid
     *
     * @return string
     */
    public function getOrganizationUuid()
    {
        return $this->organizationUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_organizationUuid;
}
