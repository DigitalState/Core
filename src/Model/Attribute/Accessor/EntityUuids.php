<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait EntityUuids
 *
 * @package Ds\Component\Model
 */
trait EntityUuids
{
    /**
     * Set entity uuids
     *
     * @param array $entityUuids
     * @return object
     */
    public function setEntityUuids(?array $entityUuids)
    {
        $this->entityUuids = $entityUuids;

        return $this;
    }

    /**
     * Get entity uuids
     *
     * @return array
     */
    public function getEntityUuids(): ?array
    {
        return $this->entityUuids;
    }
}
