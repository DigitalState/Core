<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

use DomainException;

/**
 * Trait Entity
 *
 * @package Ds\Component\Acl
 */
trait Entity
{
    /**
     * Set entity
     *
     * @param string $entity
     * @return object
     * @throws \DomainException
     */
    public function setEntity(?string $entity)
    {
        if (null !== $entity) {
            if (!preg_match('/^[a-z]+$/i', $entity)) {
                throw new DomainException('Entity "'.$entity.'" is not valid.');
            }
        }

        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity(): ?string
    {
        return $this->entity;
    }
}
