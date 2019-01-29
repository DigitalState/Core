<?php

namespace Ds\Component\Encryption\EventListener\Entity\Encryptable;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Ds\Component\Encryption\Model\Type\Encryptable;

/**
 * Class PreFlushListener
 *
 * @package Ds\Component\Encryption
 */
final class PreFlushListener extends AbstractListener
{
    /**
     * Encrypt encryptable entity properties before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entities = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($entities as $entity) {
            if (!$entity instanceof Encryptable) {
                continue;
            }

            $this->encryptionService->encrypt($entity);
        }
    }
}
