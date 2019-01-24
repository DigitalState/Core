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
     * Returns entity, that this translation is mapped to.
     *
     * @return Translatable
     */
    public function getTranslatable();
}
