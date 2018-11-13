<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait TenantIdIn
 *
 * @package Ds\Component\Camunda
 */
trait TenantIdIn
{
    /**
     * @var array
     */
    private $tenantIdIn; # region accessors

    /**
     * Set tenant id in
     *
     * @param array $tenantIdIn
     * @return object
     */
    public function setTenantIdIn(array $tenantIdIn)
    {
        $this->tenantIdIn = $tenantIdIn;
        $this->_tenantIdIn = null !== $tenantIdIn;

        return $this;
    }

    /**
     * Get tenantIdIn
     *
     * @return array
     */
    public function getTenantIdIn(): array
    {
        return $this->tenantIdIn;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_tenantIdIn;
}
