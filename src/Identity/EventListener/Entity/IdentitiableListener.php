<?php

namespace Ds\Component\Identity\EventListener\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Identity\Service\IdentityService;
use Ds\Component\Model\Type\Identitiable;

/**
 * Class IdentitiableListener
 *
 * @package Ds\Component\Identity
 */
final class IdentitiableListener
{
    /**
     * @var \Ds\Component\Identity\Service\IdentityService
     */
    private $identityService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Identity\Service\IdentityService $identityService
     */
    public function __construct(IdentityService $identityService)
    {
        $this->identityService = $identityService;
    }

    /**
     * Assign the current session identity, if none provided
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Identitiable) {
            return;
        }

        $this->identityService->generateIdentity($entity);
    }
}
