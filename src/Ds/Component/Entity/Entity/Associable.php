<?php

namespace Ds\Component\Entity\Entity;

/**
 * Interface Associable
 */
interface Associable
{
    /**
     * Set entity
     *
     * @param string $entity
     * @return object
     */
    public function setEntity($entity);

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity();

    /**
     * Set entity uuid
     *
     * @param string $entityUuid
     * @return object
     */
    public function setEntityUuid($entityUuid);

    /**
     * Get entity uuid
     *
     * @return string
     */
    public function getEntityUuid();
}
