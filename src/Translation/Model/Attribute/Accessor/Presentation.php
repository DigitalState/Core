<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Presentation
 *
 * @package Ds\Component\Translation
 */
trait Presentation
{
    /**
     * Set presentation
     *
     * @param array $presentation
     * @return object
     */
    public function setPresentation(array $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return array
     */
    public function getPresentation()
    {
        return $this->presentation;
    }
}
