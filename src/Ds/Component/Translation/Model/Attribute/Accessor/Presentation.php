<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Presentation
 */
trait Presentation
{
    /**
     * Set presentation
     *
     * @param array $presentation
     * @return object
     */
    public function setPresentation(array $presentation)
    {
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
     * Get presentation
     *
     * @return array
     */
    public function getPresentation()
    {
        return $this->presentation;
    }
}
