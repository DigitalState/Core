<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Possessor
 *
 * @package Ds\Component\Model
 */
trait Possessor
{
    /**
     * Set possessor
     *
     * @param string $possessor
     * @return object
     */
    public function setPossessor($possessor)
    {
        $this->possessor = $possessor;

        return $this;
    }

    /**
     * Get possessor
     *
     * @return string
     */
    public function getPossessor()
    {
        return $this->possessor;
    }
}
