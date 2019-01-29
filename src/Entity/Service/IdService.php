<?php

namespace Ds\Component\Entity\Service;

use Ds\Component\Model\Type\CustomIdentifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ramsey\Uuid\Uuid;

/**
 * Class IdService
 *
 * @package Ds\Component\Entity
 */
class IdService
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Generate entity custom id, if none present
     *
     * @param \Ds\Component\Model\Type\CustomIdentifiable $entity
     * @param boolean $overwrite
     * @return \Ds\Component\Entity\Service\IdService
     */
    public function generateCustomId(CustomIdentifiable $entity, bool $overwrite = false)
    {
        if (null === $entity->getCustomId() || $overwrite) {
            $customId = uniqid();
            $entity->setCustomId($customId);
        }

        return $this;
    }

    /**
     * Generate entity uuid, if none present
     *
     * @param \Ds\Component\Model\Type\Uuidentifiable $entity
     * @param boolean $overwrite
     * @return \Ds\Component\Entity\Service\IdService
     */
    public function generateUuid(Uuidentifiable $entity, bool $overwrite = false)
    {
        if (null === $entity->getUuid() || $overwrite) {
            $uuid = Uuid::uuid4()->toString();
            $entity->setUuid($uuid);
        }

        return $this;
    }
}
