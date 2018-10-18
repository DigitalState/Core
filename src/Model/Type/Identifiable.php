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
     * @return \Ds\Component\Model\Type\Identifiable
     */
    public function setId(int $id): Identifiable;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): ?int;
}
