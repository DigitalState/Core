<?php

namespace Ds\Component\Parameter\EventListener\Entity\Parameter\Serializer;

use Doctrine\ORM\Event\PostFlushEventArgs;
use Ds\Component\Parameter\Entity\Parameter;

/**
 * Class PostFlushListener
 *
 * @package Ds\Component\Parameter
 */
final class PostFlushListener
{
    /**
     * Unserialize parameter entity value property after saving from storage.
     *
     * @param \Doctrine\ORM\Event\PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        $maps = $args->getEntityManager()->getUnitOfWork()->getIdentityMap();

        foreach ($maps as $entities) {
            foreach ($entities as $entity) {
                if (!$entity instanceof Parameter) {
                    continue;
                }

                $entity->setValue(unserialize($entity->getValue()));
            }
        }
    }
}
