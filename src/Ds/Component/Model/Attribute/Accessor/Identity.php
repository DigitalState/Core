<?php

namespace Ds\Component\Model\Attribute\Accessor;

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
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
