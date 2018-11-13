<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Tags
 *
 * @package Ds\Component\Formio
 */
trait Tags
{
    /**
     * @var array
     */
    private $tags; # region accessors

    /**
     * Set tags
     *
     * @param array $tags
     * @return object
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    # endregion
}
