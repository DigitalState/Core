<?php

namespace Ds\Component\Entity\Entity\Accessor\Translation;

/**
 * Trait Presentation
 */
trait Presentation
{
    /**
     * Set presentation
     *
     * @param array|string $presentation
     * @return object
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Add presentation
     *
     * @param string $presentation
     * @param string $locale
     * @return object
     */
    public function addPresentation($locale, $presentation)
    {
        $this->presentation[$locale] = $presentation;

        return $this;
    }

    /**
     * Remove presentation
     *
     * @param string $locale
     * @return object
     */
    public function removePresentation($locale)
    {
        if (array_key_exists($locale, $this->presentation)) {
            unset($this->presentation[$locale]);
        }

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
