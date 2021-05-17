<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

use LogicException;

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
     * @throws
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

    /**
     * Get scope operator
     *
     * @return string
     */
    public function getScopeOperator(): ?string
    {
        $operator = 'and';

        if (isset($this->scope['operator'])) {
            if (!in_array($this->scope['operator'], ['and', 'or'], true)) {
                throw new LogicException('Permission scope operator is not valid.');
            }

            $operator = $this->scope['operator'];
        }

        return $operator;
    }

    /**
     * Get scope conditions
     *
     * @return array
     */
    public function getScopeConditions(): array
    {
        $conditions = [];

        if (isset($this->scope['conditions'])) {
            if (!is_array($this->scope['conditions'])) {
                throw new LogicException('Permission scope consitions is not valid.');
            }

            $conditions = $this->scope['conditions'];
        } else if ($this->scope) {
            $conditions = [$this->scope];
        }

        return $conditions;
    }
}
