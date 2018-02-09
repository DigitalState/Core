<?php

namespace Ds\Component\Entity\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Model\Type\Possessable;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class PossessableListener
 *
 * @package Ds\Component\Entity
 */
class PossessableListener
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Assign the current session identity to possessor, if none provided
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Possessable) {
            return;
        }

        if (null !== $entity->getPossessable()) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        $entity
            ->setPossessable($user->getIdentity())
            ->setPossessableUuid($user->getIdentityUuid());
    }
}
