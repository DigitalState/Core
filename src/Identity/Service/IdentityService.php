<?php

namespace Ds\Component\Identity\Service;

use Ds\Component\Model\Type\Identitiable;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IdentityService
 *
 * @package Ds\Component\Identity
 */
final class IdentityService
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Generate entity identity, if none present
     *
     * @param \Ds\Component\Model\Type\Identitiable $model
     * @param boolean $overwrite
     * @return \Ds\Component\Identity\Service\IdentityService
     */
    public function generateIdentity(Identitiable $model, bool $overwrite = false)
    {
        if (null === $model->getIdentity() || $overwrite) {
            $user = $this->tokenStorage->getToken()->getUser();
            $model
                ->setIdentity($user->getIdentity()->getType())
                ->setIdentityUuid($user->getIdentity()->getUuid());
        }

        return $this;
    }
}
