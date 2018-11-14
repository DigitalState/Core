<?php

namespace Ds\Component\Tenant\Model\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait Tenant
 *
 * @package Ds\Component\Tenant
 */
trait Tenant
{
    /**
     * Set tenant
     *
     * @param string $tenant
     * @return object
     */
    public function setTenant(?string $tenant)
    {
        if (null !== $tenant) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $tenant)) {
                throw new InvalidArgumentException('Tenant uuid is not valid.');
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
    public function getTenant(): ?string
    {
        return $this->tenant;
    }
}
