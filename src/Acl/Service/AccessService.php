<?php

namespace Ds\Component\Acl\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Acl\Entity\Access;
use Ds\Component\Entity\Service\EntityService;
use Ds\Component\Security\Model\User;

/**
 * Class AccessService
 *
 * @package Ds\Component\Acl
 */
final class AccessService extends EntityService
{
    /**
     * @var array
     */
    private $cache;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, string $entity = Access::class)
    {
        parent::__construct($manager, $entity);
        $this->cache = [];
    }

    /**
     * Get user compiled permissions
     *
     * @param \Ds\Component\Security\Model\User $user
     * @param boolean $cache
     * @return ArrayCollection
     */
    public function getPermissions(User $user, bool $cache = false)
    {
        if ($cache) {
            if (array_key_exists($user->getUuid(), $this->cache)) {
                return $this->cache[$user->getUuid()];
            }
        }

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
        $roles = $user->getIdentity()->getRoles();

        $accesses = $this->repository->findBy([
            'assignee' => 'Role',
            'assigneeUuid' => array_keys($roles)
        ]);

        foreach ($accesses as $access) {
            $role = $access->getAssigneeUuid();

            foreach ($access->getPermissions() as $permission) {
                $scope = $permission->getScope();

                if ('*' === $scope->getEntityUuid()) {
                    if ('owner' === $scope->getType() && 'BusinessUnit' === $scope->getEntity()) {
                        foreach ($roles[$role] as $businessUnit) {
                            $clone = clone $permission;
                            $clone->getScope()->setEntityUuid($businessUnit);
                            $permissions->add($clone);
                        }
                    } else {

                    }
                } else {
                    $permissions->add($permission);
                }
            }
        }

        if ($cache) {
            $this->cache[$user->getUuid()] = $permissions;
        }

        return $permissions;
    }
}
