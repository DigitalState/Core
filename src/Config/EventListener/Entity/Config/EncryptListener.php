<?php

namespace Ds\Component\Config\EventListener\Entity\Config;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Ds\Component\Config\Collection\ConfigCollection;
use Ds\Component\Config\Entity\Config;

/**
 * Class EncryptListener
 *
 * @package Ds\Component\Config
 */
final class EncryptListener
{
    /**
     * @var \Ds\Component\Config\Collection\ConfigCollection
     */
    private $configCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Collection\ConfigCollection $configCollection
     */
    public function __construct(ConfigCollection $configCollection)
    {
        $this->configCollection = $configCollection;
    }

    /**
     * Set config entity encrypt property after retrieving them from storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Config) {
            return;
        }

        $key = $entity->getKey();
        $encrypt = $this->configCollection->get($key)['encrypt'];
        $entity->setEncrypt($encrypt);
    }

    /**
     * Set config entity encrypt property before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Config) {
            return;
        }

        $key = $entity->getKey();
        $encrypt = $this->configCollection->get($key)['encrypt'];
        $entity->setEncrypt($encrypt);
    }

    /**
     * Set config entity encrypt property before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entities = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($entities as $entity) {
            if (!$entity instanceof Config) {
                continue;
            }

            $key = $entity->getKey();
            $encrypt = $this->configCollection->get($key)['encrypt'];
            $entity->setEncrypt($encrypt);
        }
    }
}
