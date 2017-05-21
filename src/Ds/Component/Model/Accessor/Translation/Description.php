<?php

namespace Ds\Component\Model\Accessor\Translation;

/**
 * Trait Description
 */
trait Description
{
    /**
     * Set description
     *
     * @param array|string $description
     * @return object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Add description
     *
     * @param string $description
     * @param string $locale
     * @return object
     */
    public function addDescription($locale, $description)
    {
        $this->description[$locale] = $description;

        return $this;
    }

    /**
     * Remove description
     *
     * @param string $locale
     * @return object
     */
    public function removeDescription($locale)
    {
        if (array_key_exists($locale, $this->description)) {
            unset($this->description[$locale]);
        }

        return $this;
    }

    /**
     * Get description
     *
     * @return array
     */
    public function getDescription()
    {
        return $this->description;
    }
}
