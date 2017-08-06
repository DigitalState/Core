<?php

namespace Ds\Component\Entity\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Entity\Service\SequenceService;
use Ds\Component\Model\Type\CustomIdentifiable;

/**
 * Class CustomIdentifiableListener
 *
 * @package Ds\Component\Entity
 */
class CustomIdentifiableListener
{
    /**
     * @var \Ds\Component\Entity\Service\SequenceService
     */
    protected $sequenceService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Entity\Service\SequenceService $sequenceService
     */
    public function __construct(SequenceService $sequenceService)
    {
        $this->sequenceService = $sequenceService;
    }

    /**
     * Generate a custom id before persisting the entity
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof CustomIdentifiable) {
            return;
        }

        if (null !== $entity->getCustomId()) {
            return;
        }

        $sequence = $this->sequenceService->create();
        $entity->setCustomId($sequence);
    }
}
