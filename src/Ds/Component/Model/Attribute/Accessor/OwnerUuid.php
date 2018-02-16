<?php

namespace Ds\Component\Model\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait OwnerUuid
 *
 * @package Ds\Component\Model
 */
trait OwnerUuid
{
    /**
     * Set owner uuid
     *
     * @param string $ownerUuid
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setOwnerUuid($ownerUuid)
    {
        if (null !== $ownerUuid) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $ownerUuid)) {
                throw new InvalidArgumentException('Owner uuid is not valid.');
            }
        }

        $this->ownerUuid = $ownerUuid;

        return $this;
    }

    /**
     * Get owner uuid
     *
     * @return string
     */
    public function getOwnerUuid()
    {
        return $this->ownerUuid;
    }
}
