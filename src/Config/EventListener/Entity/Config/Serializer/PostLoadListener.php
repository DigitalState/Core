<?php

namespace Ds\Component\Config\EventListener\Entity\Config\Serializer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Config\Entity\Config;

/**
 * Class PostLoadListener
 *
 * @package Ds\Component\Config
 */
final class PostLoadListener
{
    /**
     * Unserialize config entity value property after retrieving them from storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Config) {
            return;
        }

        $entity->setValue(unserialize($entity->getValue()));
    }
}
