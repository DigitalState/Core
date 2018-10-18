<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Associable
 *
 * @package Ds\Component\Model
 */
interface Associable
{
    /**
     * Set entity
     *
     * @param string $entity
     * @return \Ds\Component\Model\Type\Associable
     */
    public function setEntity(string $entity): Associable;

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity(): ?string;

    /**
     * Set entity uuid
     *
     * @param string $entityUuid
     * @return \Ds\Component\Model\Type\Associable
     */
    public function setEntityUuid(string $entityUuid): Associable;

    /**
     * Get entity uuid
     *
     * @return string
     */
    public function getEntityUuid(): ?string;
}
