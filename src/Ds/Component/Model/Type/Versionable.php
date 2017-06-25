<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Versionable
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
