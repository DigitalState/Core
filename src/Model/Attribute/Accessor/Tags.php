<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Tags
 *
 * @package Ds\Component\Model
 */
trait Tags
{
    /**
     * Set tags
     *
     * @param array $tags
     * @return object
     */
    public function setTags(?array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }
}
