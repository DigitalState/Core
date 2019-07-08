<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Anonymous as AnonymousModel;

/**
 * Trait Anonymous
 *
 * @package Ds\Component\Api
 */
trait Anonymous
{
    /**
     * Set anonymous
     *
     * @param \Ds\Component\Api\Model\Anonymous $anonymous
     * @return object
     */
    public function setAnonymous(?AnonymousModel $anonymous)
    {
        $this->anonymous = $anonymous;

        return $this;
    }

    /**
     * Get anonymous
     *
     * @return \Ds\Component\Api\Model\Anonymous
     */
    public function getAnonymous(): ?AnonymousModel
    {
        return $this->anonymous;
    }
}
