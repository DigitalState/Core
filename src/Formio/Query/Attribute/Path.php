<?php

namespace Ds\Component\Formio\Query\Attribute;

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
        $this->_path = null !== $path;

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

    /**
     * @var boolean
     */
    private $_path;
}
