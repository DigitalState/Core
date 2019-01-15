<?php

namespace Ds\Component\Model\Attribute\Translation\Accessor;

/**
 * Trait Title
 *
 * @package Ds\Component\Model
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
    public function getTitle(): array
    {
        return $this->title;
    }
}
