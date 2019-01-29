<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Path
 *
 * @package Ds\Component\Formio
 */
trait Path
{
    /**
     * @var string
     */
    private $path; # region accessors

    /**
     * Set path
     *
     * @param string $path
     * @return object
     */
    public function setPath(?string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    # endregion
}
