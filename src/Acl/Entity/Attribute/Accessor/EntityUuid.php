<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait EntityUuid
 *
 * @package Ds\Component\Acl
 */
trait EntityUuid
{
    /**
     * Set entity uuid
     *
     * @param string $entityUuid
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setEntityUuid(?string $entityUuid)
    {
        if (null !== $entityUuid && '*' !== $entityUuid) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $entityUuid)) {
                throw new InvalidArgumentException('Entity uuid is not valid.');
            }
        }

        $this->entityUuid = $entityUuid;

        return $this;
    }

    /**
     * Get entity uuid
     *
     * @return string
     */
    public function getEntityUuid(): ?string
    {
        return $this->entityUuid;
    }
}
