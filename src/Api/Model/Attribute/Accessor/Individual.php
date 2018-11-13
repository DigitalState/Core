<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Individual as IndividualModel;

/**
 * Trait Individual
 *
 * @package Ds\Component\Api
 */
trait Individual
{
    /**
     * Set individual
     *
     * @param \Ds\Component\Api\Model\Individual $individual
     * @return object
     */
    public function setIndividual(?IndividualModel $individual)
    {
        $this->individual = $individual;

        return $this;
    }

    /**
     * Get individual
     *
     * @return \Ds\Component\Api\Model\Individual
     */
    public function getIndividual(): ?IndividualModel
    {
        return $this->individual;
    }
}
