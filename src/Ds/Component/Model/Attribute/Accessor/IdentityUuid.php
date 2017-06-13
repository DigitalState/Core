<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait IdentityUuid
 */
trait IdentityUuid
{
    /**
     * Set identity uuid
     *
     * @param string $identityUuid
     * @return object
     */
    public function setIdentityUuid($identityUuid)
    {
        $this->identityUuid = $identityUuid;

        return $this;
    }

    /**
     * Get identity uuid
     *
     * @return string
     */
    public function getIdentityUuid()
    {
        return $this->identityUuid;
    }
}
