<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Versionable
 *
 * @package Ds\Component\Model
 */
interface Versionable
{
    /**
     * Set version
     *
     * @param integer $version
     * @return object
     */
    public function setVersion($version);

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion();
}
