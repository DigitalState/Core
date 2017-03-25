<?php

namespace Ds\Bundle\EntityBundle\Entity\Accessor;

/**
 * Trait Id
 */
trait Id
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
