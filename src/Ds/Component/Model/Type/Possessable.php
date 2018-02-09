<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Possessable
 *
 * @package Ds\Component\Model
 */
interface Possessable
{
    /**
     * Set possessor
     *
     * @param string $possessor
     * @return object
     */
    public function setPossessor($possessor);

    /**
     * Get possessor
     *
     * @return string
     */
    public function getPossessor();

    /**
     * Set possessor uuid
     *
     * @param string $possessorUuid
     * @return object
     */
    public function setPossessorUuid($possessorUuid);

    /**
     * Get possessor uuid
     *
     * @return string
     */
    public function getPossessorUuid();
}
