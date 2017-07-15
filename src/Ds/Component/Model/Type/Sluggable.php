<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Sluggable
 */
interface Sluggable
{
    /**
     * Set slug
     *
     * @param string $slug
     * @return object
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug();
}
