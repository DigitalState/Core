<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Value
 */
trait Value
{
    /**
     * @var boolean
     */
    private $valueInitialized = false;

    /**
     * Set value
     *
     * @param array|string $value
     * @return object
     */
    public function setValue($value)
    {
        $this->initializeValue();

        if (!is_array($value)) {
            $value = [$this->getDefaultLocale() => $value];
        }

        foreach ($this->getTranslations() as $translation) {
            $translation->setValue(null);
        }


        foreach ($value as $locale => $v) {
            $this->translate($locale, false)->setValue($v);
        }

        $this->mergeNewTranslations();
        $this->value = $value;

        return $this;
    }

    /**
     * Add value
     *
     * @param string $value
     * @param string $locale
     * @return object
     */
    public function addValue($locale, $value)
    {
        $this->initializeValue();
        $this->translate($locale, false)->setValue($value);
        $this->mergeNewTranslations();
        $this->value[$locale] = $value;

        return $this;
    }

    /**
     * Remove value
     *
     * @param string $locale
     * @return object
     */
    public function removeValue($locale)
    {
        $this->initializeValue();

        if (array_key_exists($locale, $this->value)) {
            $this->translate($locale, false)->setValue(null);
            $this->mergeNewTranslations();
            unset($this->value[$locale]);
        }

        return $this;
    }

    /**
     * Get value
     *
     * @return array
     */
    public function getValue()
    {
        $this->initializeValue();

        return $this->value;
    }

    /**
     * Initialize translations
     */
    private function initializeValue()
    {
        if ($this->valueInitialized) {
            return;
        }

        $this->value = [];

        foreach ($this->getTranslations() as $translation) {
            $this->value[$translation->getLocale()] = $translation->getValue();
        }

        $this->valueInitialized = true;
    }
}
