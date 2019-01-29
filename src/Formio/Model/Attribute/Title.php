<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Title
 *
 * @package Ds\Component\Formio
 */
trait Title
{
    /**
     * @var string
     */
    private $title; # region accessors

    /**
     * Set title
     *
     * @param string $title
     * @return object
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    # endregion
}
