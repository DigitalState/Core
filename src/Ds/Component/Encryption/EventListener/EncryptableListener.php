<?php

namespace Ds\Component\Encryption\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Ds\Component\Encryption\Model\Type\Encryptable;
use Ds\Component\Encryption\Service\EncryptionService;

/**
 * Class EncryptableListener
 *
 * @package Ds\Component\Encryption
 */
final class EncryptableListener
{
    /**
     * @var \Ds\Component\Encryption\Service\EncryptionService
     */
    private $encryptionService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Encryption\Service\EncryptionService
     */
    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    /**
     * Encrypt encryptable entity properties before persisting to storage.
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

        $this->encryptionService->decrypt($entity);
    }
}
