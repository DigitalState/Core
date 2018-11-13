<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait TenantId
 *
 * @package Ds\Component\Camunda
 */
trait TenantId
{
    /**
     * @var string
     */
    private $tenantId; # region accessors

    /**
     * Set tenant id
     *
     * @param string $tenantId
     * @return object
     */
    public function setTenantId(?string $tenantId)
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    /**
     * Get tenant id
     *
     * @return string
     */
    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    # endregion
}
