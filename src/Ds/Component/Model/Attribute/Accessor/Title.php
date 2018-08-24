<?php

namespace Ds\Component\Model\Attribute\Accessor;

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
     * @param string $title
     * @return object
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
