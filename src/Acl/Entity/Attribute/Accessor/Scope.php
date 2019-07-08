<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

use Ds\Component\Acl\Entity\Scope as ScopeEntity;

/**
 * Trait Scope
 *
 * @package Ds\Component\Acl
 */
trait Scope
{
    /**
     * Set scope
     *
     * @param \Ds\Component\Acl\Entity\Scope $scope
     * @return object
     */
    public function setScope(?ScopeEntity $scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return \Ds\Component\Acl\Entity\Scope
     */
    public function getScope(): ?ScopeEntity
    {
        return $this->scope;
    }
}
