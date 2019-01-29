<?php

namespace Ds\Component\Parameter\EventListener\Entity\Parameter;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Ds\Component\Parameter\Collection\ParameterCollection;
use Ds\Component\Parameter\Entity\Parameter;

/**
 * Class EncryptListener
 *
 * @package Ds\Component\Parameter
 */
final class EncryptListener
{
    /**
     * @var \Ds\Component\Parameter\Collection\ParameterCollection
     */
    private $parameterCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Parameter\Collection\ParameterCollection $parameterCollection
     */
    public function __construct(ParameterCollection $parameterCollection)
    {
        $this->parameterCollection = $parameterCollection;
    }

    /**
     * Set parameter entity encrypt property after retrieving them from storage.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Parameter) {
            return;
        }

        $key = $entity->getKey();
        $encrypt = $this->parameterCollection->get($key)['encrypt'];
        $entity->setEncrypt($encrypt);
    }

    /**
     * Set parameter entity encrypt property before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Parameter) {
            return;
        }

        $key = $entity->getKey();
        $encrypt = $this->parameterCollection->get($key)['encrypt'];
        $entity->setEncrypt($encrypt);
    }

    /**
     * Set parameter entity encrypt property before saving in storage.
     *
     * @param \Doctrine\ORM\Event\PreFlushEventArgs $args
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entities = $args->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($entities as $entity) {
            if (!$entity instanceof Parameter) {
                continue;
            }

            $key = $entity->getKey();
            $encrypt = $this->parameterCollection->get($key)['encrypt'];
            $entity->setEncrypt($encrypt);
        }
    }
}
