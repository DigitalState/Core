<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Presentation
 */
trait Presentation
{
    /**
     * @var boolean
     */
    private $presentationInitialized = false;

    /**
     * Set presentation
     *
     * @param array|string $presentation
     * @return object
     */
    public function setPresentation($presentation)
    {
        $this->initializePresentation();

        if (!is_array($presentation)) {
            $presentation = [$this->getDefaultLocale() => $presentation];
        }

        foreach ($this->getTranslations() as $translation) {
            $translation->setPresentation(null);
        }


        foreach ($presentation as $locale => $value) {
            $this->translate($locale, false)->setPresentation($value);
        }

        $this->mergeNewTranslations();
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
        $this->initializePresentation();
        $this->translate($locale, false)->setPresentation($presentation);
        $this->mergeNewTranslations();
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
        $this->initializePresentation();

        if (array_key_exists($locale, $this->presentation)) {
            $this->translate($locale, false)->setPresentation(null);
            $this->mergeNewTranslations();
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
        $this->initializePresentation();

        return $this->presentation;
    }

    /**
     * Initialize translations
     */
    private function initializePresentation()
    {
        if ($this->presentationInitialized) {
            return;
        }

        $this->presentation = [];

        foreach ($this->getTranslations() as $translation) {
            $this->presentation[$translation->getLocale()] = $translation->getPresentation();
        }

        $this->presentationInitialized = true;
    }
}
