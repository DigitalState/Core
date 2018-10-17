<?php

namespace Ds\Component\Security\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Security\Model\User;

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
     * @param \Ds\Component\Security\Model\User $user
     * @return ArrayCollection
     */
    public function getPermissions(User $user)
    {
        $permissions = new ArrayCollection;

        // Generic identity permissions
        $accesses = $this->repository->findBy([
            'assignee' => $user->getIdentity()->getType(),
            'assigneeUuid' => null
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        // Specific identity permissions
        $accesses = $this->repository->findBy([
            'assignee' => $user->getIdentity()->getType(),
            'assigneeUuid' => $user->getIdentity()->getUuid()
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        // Roles permissions
        $accesses = $this->repository->findBy([
            'assignee' => 'Role',
            'assigneeUuid' => $user->getIdentity()->getRoles()
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        return $permissions;
    }
}
