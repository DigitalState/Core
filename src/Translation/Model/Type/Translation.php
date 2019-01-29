<?php

namespace Ds\Component\Translation\Model\Type;

/**
 * Interface Translation
 *
 * @package Ds\Component\Translation
 */
interface Translation
{
    /**
     * Get the entity that this translation is mapped to.
     *
     * @return Translatable
     */
    public function getTranslatable();

    /**
     * Get the locale
     *
     * @return string
     */
    public function getLocale();
}
