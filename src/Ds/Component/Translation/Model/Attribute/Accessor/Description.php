<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Description
 */
trait Description
{
    /**
     * @var boolean
     */
    private $descriptionInitialized = false;

    /**
     * Set description
     *
     * @param array|string $description
     * @return object
     */
    public function setDescription($description)
    {
        $this->initializeDescription();

        if (!is_array($description)) {
            $description = [$this->getDefaultLocale() => $description];
        }

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
     * Add description
     *
     * @param string $description
     * @param string $locale
     * @return object
     */
    public function addDescription($locale, $description)
    {
        $this->initializeDescription();
        $this->translate($locale, false)->setDescription($description);
        $this->mergeNewTranslations();
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
        $this->initializeDescription();

        if (array_key_exists($locale, $this->description)) {
            $this->translate($locale, false)->setDescription(null);
            $this->mergeNewTranslations();
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
        $this->initializeDescription();

        return $this->description;
    }

    /**
     * Initialize translations
     */
    private function initializeDescription()
    {
        if ($this->descriptionInitialized) {
            return;
        }

        $this->description = [];

        foreach ($this->getTranslations() as $translation) {
            $this->description[$translation->getLocale()] = $translation->getDescription();
        }

        $this->descriptionInitialized = true;
    }
}
