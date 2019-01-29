<?php

namespace Ds\Component\Parameter\EventListener\Entity\Parameter\Serializer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Parameter\Entity\Parameter;

/**
 * Class PostUpdateListener
 *
 * @package Ds\Component\Parameter
 */
final class PostUpdateListener
{
    /**
     * Unserialize parameter entity value property after saving in storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Parameter) {
            return;
        }

        $entity->setValue(unserialize($entity->getValue()));
    }
}
