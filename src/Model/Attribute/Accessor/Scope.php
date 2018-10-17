<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;
use ReflectionClass;

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
     * @param integer $scope
     * @return object
     * @throws \DomainException
     */
    public function setScope($scope = null)
    {
        if (null !== $scope && $this->getScopes() && !in_array($scope, $this->getScopes(), true)) {
            throw new DomainException('Scope does not exist.');
        }

        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return integer
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes()
    {
        static $scopes;

        if (null === $scopes) {
            $scopes = [];
            $class = new ReflectionClass($this);

            foreach ($class->getConstants() as $constant => $value) {
                if ('SCOPE_' === substr($constant, 0, 6)) {
                    $scopes[] = $value;
                }
            }
        }

        return $scopes;
    }
}
