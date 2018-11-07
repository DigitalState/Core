<?php

namespace Ds\Component\Encryption\EventListener\Entity\Encryptable;

use Doctrine\ORM\Event\PostFlushEventArgs;
use Ds\Component\Encryption\Model\Type\Encryptable;

/**
 * Class PostFlushListener
 *
 * @package Ds\Component\Encryption
 */
final class PostFlushListener extends AbstractListener
{
    /**
     * Decrypt encryptable entity properties after saving in storage.
     *
     * @param \Doctrine\ORM\Event\PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        $maps = $args->getEntityManager()->getUnitOfWork()->getIdentityMap();

        foreach ($maps as $entities) {
            foreach ($entities as $entity) {
                if (!$entity instanceof Encryptable) {
                    continue;
                }

                $this->encryptionService->decrypt($entity);
            }
        }
    }
}
