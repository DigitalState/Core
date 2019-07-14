<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Scope as ScopeModel;

/**
 * Trait Scope
 *
 * @package Ds\Component\Api
 */
trait Scope
{
    /**
     * Set scope
     *
     * @param \Ds\Component\Api\Model\Scope $scope
     * @return object
     */
    public function setScope(?ScopeModel $scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return \Ds\Component\Api\Model\Scope
     */
    public function getScope(): ?ScopeModel
    {
        return $this->scope;
    }
}
