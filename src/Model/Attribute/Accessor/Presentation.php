<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Presentation
 *
 * @package Ds\Component\Model
 */
trait Presentation
{
    /**
     * Set presentation
     *
     * @param string $presentation
     * @return object
     */
    public function setPresentation(?string $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation(): ?string
    {
        return $this->presentation;
    }
}
