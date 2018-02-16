<?php

namespace Ds\Component\Model\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait IdentityUuid
 *
 * @package Ds\Component\Model
 */
trait IdentityUuid
{
    /**
     * Set identity uuid
     *
     * @param string $identityUuid
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setIdentityUuid($identityUuid)
    {
        if (null !== $identityUuid) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $identityUuid)) {
                throw new InvalidArgumentException('Owner uuid is not valid.');
            }
        }

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
