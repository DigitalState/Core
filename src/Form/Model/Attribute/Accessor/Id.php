<?php

namespace Ds\Component\Form\Model\Attribute\Accessor;

/**
 * Trait Id
 *
 * @package Ds\Component\Form
 */
trait Id
{
    /**
     * Set id
     *
     * @param string $id
     * @return object
     */
    public function setId(?string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
