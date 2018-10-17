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
        $this->_tenantId = null !== $tenantId;

        return $this;
    }

    /**
     * Get tenantId
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_tenantId;
}
