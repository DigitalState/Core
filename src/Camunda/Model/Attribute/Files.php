<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Files
 *
 * @package Ds\Component\Camunda
 */
trait Files
{
    /**
     * @var array
     */
    private $files; # region accessors

    /**
     * Set files
     *
     * @param array $files
     * @return object
     */
    public function setFiles(array $files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    # endregion
}
