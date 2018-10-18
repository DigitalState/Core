<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;

/**
 * Trait Identity
 *
 * @package Ds\Component\Model
 */
trait Identity
{
    /**
     * Set identity
     *
     * @param string $identity
     * @return object
     * @throws \DomainException
     */
    public function setIdentity(?string $identity)
    {
        if (null !== $identity) {
            if (!preg_match('/^[a-z]+$/i', $identity)) {
                throw new DomainException('Identity is not valid.');
            }
        }

        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity(): ?string
    {
        return $this->identity;
    }
}
