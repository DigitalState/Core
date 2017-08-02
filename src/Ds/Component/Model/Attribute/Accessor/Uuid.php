<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Uuid
 *
 * @package Ds\Component\Model
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
