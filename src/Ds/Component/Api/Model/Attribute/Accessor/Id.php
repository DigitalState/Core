<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

/**
 * Trait Id
 *
 * @package Ds\Component\Api
 */
trait Id
{
    /**
     * Set id
     *
     * @param integer $id
     * @return object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
