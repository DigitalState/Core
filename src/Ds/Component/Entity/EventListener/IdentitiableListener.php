<?php

namespace Ds\Component\Entity\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Model\Type\Identitiable;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class IdentitiableListener
 *
 * @package Ds\Component\Entity
 */
class IdentitiableListener
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

        if (null !== $entity->getIdentity()) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        $entity
            ->setIdentity($user->getIdentity())
            ->setIdentityUuid($user->getIdentityUuid());
    }
}
