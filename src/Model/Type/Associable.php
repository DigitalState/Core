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
     */
    public function setEntity(?string $entity);

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
     */
    public function setEntityUuid(?string $entityUuid);

    /**
     * Get entity uuid
     *
     * @return string
     */
    public function getEntityUuid(): ?string;
}
