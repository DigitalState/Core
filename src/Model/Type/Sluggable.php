<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Sluggable
 *
 * @package Ds\Component\Model
 */
interface Sluggable
{
    /**
     * Set slug
     *
     * @param string $slug
     * @return \Ds\Component\Model\Type\Sluggable
     */
    public function setSlug(string $slug): Sluggable;

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): ?string;
}
