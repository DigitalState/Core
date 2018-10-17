<?php

namespace Ds\Component\Identity\Model\Attribute\Accessor;

/**
 * Trait Type
 *
 * @package Ds\Component\Identity
 */
trait Type
{
    /**
     * Set type
     *
     * @param string $type
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
