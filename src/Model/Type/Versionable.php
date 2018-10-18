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
     * @return \Ds\Component\Model\Type\Versionable
     */
    public function setVersion(int $version): Versionable;

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion(): ?int;
}
