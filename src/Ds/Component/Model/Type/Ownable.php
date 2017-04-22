<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Ownable
 */
interface Ownable
{
    /**
     * Set owner
     *
     * @param string $owner
     * @return object
     */
    public function setOwner($owner);

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner();

    /**
     * Set owner uuid
     *
     * @param string $ownerUuid
     * @return object
     */
    public function setOwnerUuid($ownerUuid);

    /**
     * Get owner uuid
     *
     * @return string
     */
    public function getOwnerUuid();
}
