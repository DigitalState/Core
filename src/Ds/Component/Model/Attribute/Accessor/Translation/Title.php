<?php

namespace Ds\Component\Model\Attribute\Accessor\Translation;

/**
 * Trait Title
 */
trait Title
{
    /**
     * Set title
     *
     * @param array|string $title
     * @return object
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Add title
     *
     * @param string $title
     * @param string $locale
     * @return object
     */
    public function addTitle($locale, $title)
    {
        $this->title[$locale] = $title;

        return $this;
    }

    /**
     * Remove title
     *
     * @param string $locale
     * @return object
     */
    public function removeTitle($locale)
    {
        if (array_key_exists($locale, $this->title)) {
            unset($this->title[$locale]);
        }

        return $this;
    }

    /**
     * Get title
     *
     * @return array
     */
    public function getTitle()
    {
        return $this->title;
    }
}
