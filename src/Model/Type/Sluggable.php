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
     */
    public function setSlug(?string $slug);

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): ?string;
}
