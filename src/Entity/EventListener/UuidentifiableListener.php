<?php

namespace Ds\Component\Entity\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Entity\Service\IdService;
use Ds\Component\Model\Type\Uuidentifiable;

/**
 * Class UuidentifiableListener
 *
 * @package Ds\Component\Entity
 */
final class UuidentifiableListener
{
    /**
     * @var \Ds\Component\Entity\Service\IdService
     */
    private $idService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Entity\Service\IdService $idService
     */
    public function __construct(IdService $idService)
    {
        $this->idService = $idService;
    }

    /**
     * Generate an uuid before persisting the entity, if none provided
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Uuidentifiable) {
            return;
        }

        $this->idService->generateUuid($entity);
    }
}
