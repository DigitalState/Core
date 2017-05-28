<?php

namespace Ds\Component\Model\Accessor;

/**
 * Trait Version
 */
trait Version
{
    /**
     * Set version
     *
     * @param integer $version
     * @return object
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }
}
