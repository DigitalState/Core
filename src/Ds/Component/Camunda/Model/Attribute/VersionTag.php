<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait VersionTag
 *
 * @package Ds\Component\Camunda
 */
trait VersionTag
{
    /**
     * @var string
     */
    protected $versionTag; # region accessors

    /**
     * Set version tag
     *
     * @param string $versionTag
     * @return object
     */
    public function setVersionTag($versionTag)
    {
        $this->versionTag = $versionTag;

        return $this;
    }

    /**
     * Get version tag
     *
     * @return string
     */
    public function getVersionTag()
    {
        return $this->versionTag;
    }

    # endregion
}
