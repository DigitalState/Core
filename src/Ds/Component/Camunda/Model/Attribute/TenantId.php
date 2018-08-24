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
    protected $tenantId; # region accessors

    /**
     * Set tenant id
     *
     * @param string $tenantId
     * @return object
     */
    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;

        return $this;
    }

    /**
     * Get tenant id
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    # endregion
}
