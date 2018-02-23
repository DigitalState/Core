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
     * @var string
     */
    protected $files; # region accessors

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
    public function getFiles()
    {
        return $this->files;
    }

    # endregion
}
