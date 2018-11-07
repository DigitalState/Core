<?php

namespace Ds\Component\Encryption\EventListener\Entity\Encryptable;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Ds\Component\Encryption\Model\Type\Encryptable;

/**
 * Class PreUpdateListener
 *
 * @package Ds\Component\Encryption
 */
final class PreUpdateListener extends AbstractListener
{
    /**
     * Encrypt encryptable entity properties before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Encryptable) {
            return;
        }

        $this->encryptionService->encrypt($entity);
    }
}
