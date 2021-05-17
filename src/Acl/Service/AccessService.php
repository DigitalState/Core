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

        // Permissions assigned to the identity type.
        $accesses = $this->repository->findBy([
            'assignee' => $user->getIdentity()->getType(),
            'assigneeUuid' => null
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        // Permissions assigned to the identity uuid.
        $accesses = $this->repository->findBy([
            'assignee' => $user->getIdentity()->getType(),
            'assigneeUuid' => $user->getIdentity()->getUuid()
        ]);

        foreach ($accesses as $access) {
            foreach ($access->getPermissions() as $permission) {
                $permissions->add($permission);
            }
        }

        // Permissions assigned to a role.
        $roles = $user->getIdentity()->getRoles();

        $accesses = $this->repository->findBy([
            'assignee' => 'Role',
            'assigneeUuid' => array_keys($roles)
        ]);

        foreach ($accesses as $access) {
            $role = $access->getAssigneeUuid();

            foreach ($access->getPermissions() as $permission) {
                $scope = $permission->getScope();

                if (array_key_exists('conditions', $scope)) {
                    $dynamic = false;

                    foreach ($scope['conditions'] as $condition) {
                        if (array_key_exists('entity_uuid', $condition)) {
                            if ('*' === $condition['entity_uuid']) {
                                $dynamic = true;
                            }
                        }
                    }

                    if ($dynamic) {
                        foreach ($roles[$role] as $entityUuid) {
                            $clone = clone $permission;
                            $cloneScope = $clone->getScope();

                            foreach ($cloneScope['conditions'] as $key => $condition) {
                                if (array_key_exists('entity_uuid', $condition)) {
                                    if ('*' === $condition['entity_uuid']) {
                                        $cloneScope['conditions'][$key]['entity_uuid'] = $entityUuid;
                                    }
                                }
                            }

                            $clone->setScope($cloneScope);
                            $permissions->add($clone);
                        }
                    } else {
                        $permissions->add($permission);
                    }
                } else if (array_key_exists('entity_uuid', $scope)) {
                    $dynamic = false;

                    if ('*' === $scope['entity_uuid']) {
                        $dynamic = true;
                    }

                    if ($dynamic) {
                        foreach ($roles[$role] as $entityUuid) {
                            $clone = clone $permission;
                            $cloneScope = $clone->getScope();
                            $cloneScope['entity_uuid'] = $entityUuid;
                            $clone->setScope($cloneScope);
                            $permissions->add($clone);
                        }
                    } else {
                        $permissions->add($permission);
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
