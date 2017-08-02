<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Description
 *
 * @package Ds\Component\Translation
 */
trait Description
{
    /**
     * Set description
     *
     * @param array $description
     * @return object
     */
    public function setDescription(array $description)
    {
        foreach ($this->getTranslations() as $translation) {
            $translation->setDescription(null);
        }

        foreach ($description as $locale => $value) {
            $this->translate($locale, false)->setDescription($value);
        }

        $this->mergeNewTranslations();
        $this->description = $description;

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
