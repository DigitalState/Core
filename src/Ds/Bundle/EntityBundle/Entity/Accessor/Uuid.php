<?php

namespace Ds\Bundle\EntityBundle\Entity\Accessor;

/**
 * Trait Uuid
 */
trait Uuid
{
    /**
     * Set uuid
     *
     * @param string $uuid
     * @return object
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
