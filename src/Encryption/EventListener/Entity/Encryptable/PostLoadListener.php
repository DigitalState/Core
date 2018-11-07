<?php

namespace Ds\Component\Encryption\EventListener\Entity\Encryptable;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Encryption\Model\Type\Encryptable;

/**
 * Class PostLoadListener
 *
 * @package Ds\Component\Encryption
 */
final class PostLoadListener extends AbstractListener
{
    /**
     * Decrypt encryptable entity properties after retrieving them from storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Encryptable) {
            return;
        }

        $entity->setEncrypted(true);
        $this->encryptionService->decrypt($entity);
    }
}
