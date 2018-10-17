<?php

namespace Ds\Component\Config\EventListener\Entity\Parameter\Serializer;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Ds\Component\Config\Entity\Parameter;

/**
 * Class PreUpdateListener
 *
 * @package Ds\Component\Config
 */
final class PreUpdateListener
{
    /**
     * Serialize parameter entity value property before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Parameter) {
            return;
        }

        $entity->setValue(serialize($entity->getValue()));
    }
}
