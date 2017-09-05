<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Identifiable
 *
 * @package Ds\Component\Model
 */
interface Identifiable
{
    /**
     * Set id
     *
     * @param integer $id
     * @return object
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();
}
