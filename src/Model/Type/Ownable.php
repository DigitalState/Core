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
     */
    public function setOwner(?string $owner);

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
     */
    public function setOwnerUuid(?string $ownerUuid);

    /**
     * Get owner uuid
     *
     * @return string
     */
    public function getOwnerUuid(): ?string;
}
