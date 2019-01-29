<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Title
 *
 * @package Ds\Component\Translation
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
