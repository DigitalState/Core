<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait PossessorUuid
 *
 * @package Ds\Component\Model
 */
trait PossessorUuid
{
    /**
     * Set possessor uuid
     *
     * @param string $possessorUuid
     * @return object
     */
    public function setPossessorUuid($possessorUuid)
    {
        $this->possessorUuid = $possessorUuid;

        return $this;
    }

    /**
     * Get possessor uuid
     *
     * @return string
     */
    public function getPossessorUuid()
    {
        return $this->possessorUuid;
    }
}
