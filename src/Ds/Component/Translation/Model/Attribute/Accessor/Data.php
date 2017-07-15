<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Data
 */
trait Data
{
    /**
     * @var boolean
     */
    private $dataInitialized = false;

    /**
     * Set data
     *
     * @param array|string $data
     * @return object
     */
    public function setData($data)
    {
        $this->initializeData();

        if (!is_array($data)) {
            $data = [$this->getDefaultLocale() => $data];
        }

        foreach ($this->getTranslations() as $translation) {
            $translation->setData(null);
        }


        foreach ($data as $locale => $value) {
            $this->translate($locale, false)->setData($value);
        }

        $this->mergeNewTranslations();
        $this->data = $data;

        return $this;
    }

    /**
     * Add data
     *
     * @param string $data
     * @param string $locale
     * @return object
     */
    public function addData($locale, $data)
    {
        $this->initializeData();
        $this->translate($locale, false)->setData($data);
        $this->mergeNewTranslations();
        $this->data[$locale] = $data;

        return $this;
    }

    /**
     * Remove data
     *
     * @param string $locale
     * @return object
     */
    public function removeData($locale)
    {
        $this->initializeData();

        if (array_key_exists($locale, $this->data)) {
            $this->translate($locale, false)->setData(null);
            $this->mergeNewTranslations();
            unset($this->data[$locale]);
        }

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $this->initializeData();

        return $this->data;
    }

    /**
     * Initialize translations
     */
    private function initializeData()
    {
        if ($this->dataInitialized) {
            return;
        }

        $this->data = [];

        foreach ($this->getTranslations() as $translation) {
            $this->data[$translation->getLocale()] = $translation->getData();
        }

        $this->dataInitialized = true;
    }
}
