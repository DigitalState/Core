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
    private $organizationUuid; # region accessors

    /**
     * Set organization uuid
     *
     * @param string $organizationUuid
     * @return object
     */
    public function setOrganizationUuid(?string $organizationUuid)
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
    public function getOrganizationUuid(): ?string
    {
        return $this->organizationUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_organizationUuid;
}
