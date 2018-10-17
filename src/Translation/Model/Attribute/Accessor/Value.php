<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Value
 *
 * @package Ds\Component\Translation
 */
trait Value
{
    /**
     * Set value
     *
     * @param array $value
     * @return object
     */
    public function setValue(array $value)
    {
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
     * Get value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->value;
    }
}
