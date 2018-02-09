<?php

namespace Ds\Component\Security\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Security\User\User;

/**
 * Class AccessService
 *
 * @package Ds\Component\Security
 */
class AccessService extends EntityService
{
    /**
     * Get user compiled permissions
     *
     * @param \Ds\Component\Security\User\User $user
     * @return ArrayCollection
     */
    public function getCompiled(User $user)
    {
        $permissions = new ArrayCollection;

        $accesses = $this->repository->findBy([
            'possessor' => $user->getIdentity(),
            'possessorUuid' => null
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        $accesses = $this->repository->findBy([
            'possessor' => $user->getIdentity(),
            'possessorUuid' => $user->getIdentityUuid()
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        return $permissions;
    }
}
