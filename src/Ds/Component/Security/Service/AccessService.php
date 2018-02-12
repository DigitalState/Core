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

        // Generic identity permissions
        $accesses = $this->repository->findBy([
            'possessor' => $user->getIdentity(),
            'possessorUuid' => null
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        // Specific identity permissions
        $accesses = $this->repository->findBy([
            'possessor' => $user->getIdentity(),
            'possessorUuid' => $user->getIdentityUuid()
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        // Roles permissions
        $roles = [];

        foreach ($user->getRoles() as $role) {
            if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $role)) {
                $roles[] = $role;
            }
        }

        $accesses = $this->repository->findBy([
            'possessor' => 'Role',
            'possessorUuid' => $roles
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        return $permissions;
    }
}
