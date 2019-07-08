<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\System as SystemModel;

/**
 * Trait System
 *
 * @package Ds\Component\Api
 */
trait System
{
    /**
     * Set system
     *
     * @param \Ds\Component\Api\Model\System $system
     * @return object
     */
    public function setSystem(?SystemModel $system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return \Ds\Component\Api\Model\System
     */
    public function getSystem(): ?SystemModel
    {
        return $this->system;
    }
}
