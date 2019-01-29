<?php

namespace Ds\Component\Encryption\EventListener\Entity\Encryptable;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Encryption\Model\Type\Encryptable;

/**
 * Class PostUpdateListener
 *
 * @package Ds\Component\Encryption
 */
final class PostUpdateListener extends AbstractListener
{
    /**
     * Decrypt encryptable entity properties after saving in storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Encryptable) {
            return;
        }

        $this->encryptionService->decrypt($entity);
    }
}
