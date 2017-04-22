<?php

namespace Ds\Component\Model\Accessor;

/**
 * Trait Identity
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
