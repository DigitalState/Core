<?php

namespace Ds\Component\Model\Accessor;

/**
 * Trait EntityUuid
 */
trait EntityUuid
{
    /**
     * Set entity uuid
     *
     * @param string $entityUuid
     * @return object
     */
    public function setEntityUuid($entityUuid)
    {
        $this->entityUuid = $entityUuid;

        return $this;
    }

    /**
     * Get entity uuid
     *
     * @return string
     */
    public function getEntityUuid()
    {
        return $this->entityUuid;
    }
}
