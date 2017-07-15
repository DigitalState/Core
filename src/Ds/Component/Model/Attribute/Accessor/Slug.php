<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Slug
 */
trait Slug
{
    /**
     * Set slug
     *
     * @param string $slug
     * @return object
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
