<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

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
     * @param array $scope
     * @return object
     */
    public function setScope(?array $scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return array
     */
    public function getScope(): ?array
    {
        return $this->scope;
    }
}
