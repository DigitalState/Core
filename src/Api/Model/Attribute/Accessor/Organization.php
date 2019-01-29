<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Organization as OrganizationModel;

/**
 * Trait Organization
 *
 * @package Ds\Component\Api
 */
trait Organization
{
    /**
     * Set organization
     *
     * @param \Ds\Component\Api\Model\Organization $organization
     * @return object
     */
    public function setOrganization(?OrganizationModel $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \Ds\Component\Api\Model\Organization
     */
    public function getOrganization(): ?OrganizationModel
    {
        return $this->organization;
    }
}
