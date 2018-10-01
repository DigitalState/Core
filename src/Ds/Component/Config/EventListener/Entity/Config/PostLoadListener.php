<?php

namespace Ds\Component\Config\EventListener\Entity\Config;

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
     * Set config entity encrypt property after retrieving them from storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Config) {
            return;
        }

        $entity->setEncrypt(false);
    }
}
