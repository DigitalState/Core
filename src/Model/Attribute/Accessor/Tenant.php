<?php

namespace Ds\Component\Model\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait Tenant
 *
 * @package Ds\Component\Model
 */
trait Tenant
{
    /**
     * Set tenant
     *
     * @param string $tenant
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setTenant($tenant)
    {
        if (null !== $tenant) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $tenant)) {
                throw new InvalidArgumentException('Assignee uuid is not valid.');
            }
        }

        $this->tenant = $tenant;

        return $this;
    }

    /**
     * Get tenant
     *
     * @return string
     */
    public function getTenant()
    {
        return $this->tenant;
    }
}
