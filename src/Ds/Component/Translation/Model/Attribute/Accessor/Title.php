<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Title
 */
trait Title
{
    /**
     * @var boolean
     */
    private $titleInitialized = false;

    /**
     * Set title
     *
     * @param array|string $title
     * @return object
     */
    public function setTitle($title)
    {
        $this->initializeTitle();

        if (!is_array($title)) {
            $title = [$this->getDefaultLocale() => $title];
        }

        foreach ($this->getTranslations() as $translation) {
            $translation->setTitle(null);
        }


        foreach ($title as $locale => $value) {
            $this->translate($locale, false)->setTitle($value);
        }

        $this->mergeNewTranslations();
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
        $this->initializeTitle();
        $this->translate($locale, false)->setTitle($title);
        $this->mergeNewTranslations();
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
        $this->initializeTitle();

        if (array_key_exists($locale, $this->title)) {
            $this->translate($locale, false)->setTitle(null);
            $this->mergeNewTranslations();
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
        $this->initializeTitle();

        return $this->title;
    }

    /**
     * Initialize translations
     */
    private function initializeTitle()
    {
        if ($this->titleInitialized) {
            return;
        }

        $this->title = [];

        foreach ($this->getTranslations() as $translation) {
            $this->title[$translation->getLocale()] = $translation->getTitle();
        }

        $this->titleInitialized = true;
    }
}
