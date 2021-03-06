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
     */
    public function setVersion(?int $version);

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion(): ?int;
}
