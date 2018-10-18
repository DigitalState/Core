<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Ownable
 *
 * @package Ds\Component\Model
 */
interface Ownable
{
    /**
     * Set owner
     *
     * @param string $owner
     * @return \Ds\Component\Model\Type\Ownable
     */
    public function setOwner(string $owner): Ownable;

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner(): ?string;

    /**
     * Set owner uuid
     *
     * @param string $ownerUuid
     * @return \Ds\Component\Model\Type\Ownable
     */
    public function setOwnerUuid(string $ownerUuid): Ownable;

    /**
     * Get owner uuid
     *
     * @return string
     */
    public function getOwnerUuid(): ?string;
}
