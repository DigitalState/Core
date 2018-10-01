<?php

namespace Ds\Component\Config\EventListener\Entity\Parameter;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Config\Entity\Parameter;

/**
 * Class PostLoadListener
 *
 * @package Ds\Component\Config
 */
final class PostLoadListener
{
    /**
     * Set parameter entity encrypt property after retrieving them from storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Parameter) {
            return;
        }

        $entity->setEncrypt(false);
    }
}
