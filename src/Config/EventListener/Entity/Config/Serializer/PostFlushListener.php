<?php

namespace Ds\Component\Config\EventListener\Entity\Config\Serializer;

use Doctrine\ORM\Event\PostFlushEventArgs;
use Ds\Component\Config\Entity\Config;

/**
 * Class PostFlushListener
 *
 * @package Ds\Component\Config
 */
final class PostFlushListener
{
    /**
     * Unserialize config entity value property after saving from storage.
     *
     * @param \Doctrine\ORM\Event\PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        $maps = $args->getEntityManager()->getUnitOfWork()->getIdentityMap();

        foreach ($maps as $entities) {
            foreach ($entities as $entity) {
                if (!$entity instanceof Config) {
                    continue;
                }

                $entity->setValue(unserialize($entity->getValue()));
            }
        }
    }
}
