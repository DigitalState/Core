<?php

namespace Ds\Component\Config\EventListener\Entity\Config\Serializer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Config\Entity\Config;

/**
 * Class PostUpdateListener
 *
 * @package Ds\Component\Config
 */
final class PostUpdateListener
{
    /**
     * Unserialize config entity value property after saving in storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Config) {
            return;
        }

        $entity->setValue(unserialize($entity->getValue()));
    }
}
