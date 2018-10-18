<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Id
 *
 * @package Ds\Component\Model
 */
trait Id
{
    /**
     * Set id
     *
     * @param integer $id
     * @return object
     */
    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
