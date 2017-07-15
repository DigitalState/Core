<?php

namespace Ds\Component\Entity\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Model\Type\Uuidentifiable;
use Ramsey\Uuid\Uuid;

/**
 * Class UuidentifiableListener
 */
class UuidentifiableListener
{
    /**
     * Generate an uuid before persisting the entity
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Uuidentifiable) {
            return;
        }

        if (null !== $entity->getUuid()) {
            return;
        }

        $uuid = Uuid::uuid4()->toString();
        $entity->setUuid($uuid);
    }
}
