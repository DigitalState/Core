<?php

namespace Ds\Component\Config\EventListener\Entity\Config\Serializer;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Ds\Component\Config\Entity\Config;

/**
 * Class PreFlushListener
 *
 * @package Ds\Component\Config
 */
final class PreFlushListener
{
    /**
     * Serialize config entity value property before saving to storage.
     *
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entities = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($entities as $entity) {
            if (!$entity instanceof Config) {
                continue;
            }

            $entity->setValue(serialize($entity->getValue()));
        }
    }
}
