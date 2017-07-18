<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Title
 */
trait Title
{
    /**
     * Set title
     *
     * @param array $title
     * @return object
     */
    public function setTitle(array $title)
    {
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
     * Get title
     *
     * @return array
     */
    public function getTitle()
    {
        return $this->title;
    }
}
