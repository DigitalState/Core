<?php

namespace Ds\Component\Camunda\Query\Attribute;

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
        $this->_tenantId = null !== $tenantId;

        return $this;
    }

    /**
     * Get tenantId
     *
     * @return string
     */
    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_tenantId;
}
