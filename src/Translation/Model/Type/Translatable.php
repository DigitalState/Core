<?php

namespace Ds\Component\Translation\Model\Type;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface Translatable
 *
 * @package Ds\Component\Translation
 */
interface Translatable
{
    /**
     * Get collection of translations
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTranslations();

    /**
     * Get collection of new translations
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNewTranslations();

    /**
     * Add translation.
     *
     * @param object $translation The translation
     */
    public function addTranslation($translation);

    /**
     * Remove translation
     *
     * @param object $translation
     */
    public function removeTranslation($translation);

    /**
     * Returns translation for specific locale
     *
     * @param string $locale
     * @param boolean $fallbackToDefault
     */
    public function translate($locale = null, $fallbackToDefault = true);

    /**
     * Merge newly created translations into persisted translations
     */
    public function mergeNewTranslations();

    /**
     * Set the current locale
     *
     * @param mixed $locale
     */
    public function setCurrentLocale($locale);

    /**
     * Get the current locale
     *
     * @return string
     */
    public function getCurrentLocale();

    /**
     * Set default locale
     *
     * @param mixed $locale
     */
    public function setDefaultLocale($locale);

    /**
     * Get default locale
     *
     * @return string
     */
    public function getDefaultLocale();

    /**
     * Get translation entity class name.
     *
     * @return string
     */
    public static function getTranslationEntityClass();
}
