<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Scope
 *
 * @package Ds\Component\Model
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
     * @throws \OutOfRangeException
     */
    public function getScope(): ?array
    {
        return $this->scope;
    }
}
