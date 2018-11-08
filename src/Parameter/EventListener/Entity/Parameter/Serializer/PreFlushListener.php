<?php

namespace Ds\Component\Parameter\EventListener\Entity\Parameter\Serializer;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Ds\Component\Parameter\Entity\Parameter;

/**
 * Class PreFlushListener
 *
 * @package Ds\Component\Parameter
 */
final class PreFlushListener
{
    /**
     * Serialize parameter entity value property before saving to storage.
     *
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entities = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($entities as $entity) {
            if (!$entity instanceof Parameter) {
                continue;
            }

            $entity->setValue(serialize($entity->getValue()));
        }
    }
}
