<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Presentation
 */
trait Presentation
{
    /**
     * Set presentation
     *
     * @param string $presentation
     * @return object
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }
}
