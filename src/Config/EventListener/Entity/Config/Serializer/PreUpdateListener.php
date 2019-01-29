<?php

namespace Ds\Component\Config\EventListener\Entity\Config\Serializer;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Ds\Component\Config\Entity\Config;

/**
 * Class PreUpdateListener
 *
 * @package Ds\Component\Config
 */
final class PreUpdateListener
{
    /**
     * Serialize config entity value property before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Config) {
            return;
        }

        $entity->setValue(serialize($entity->getValue()));
    }
}
