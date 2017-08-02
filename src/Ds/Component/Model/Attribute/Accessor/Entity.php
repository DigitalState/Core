<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Entity
 *
 * @package Ds\Component\Model
 */
trait Entity
{
    /**
     * Set entity
     *
     * @param string $entity
     * @return object
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
