<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Service\AccessService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class GenericVoter
 *
 * @package Ds\Component\Security
 * @example Grant access if the user can execute the cache_clear permission
 * <code>
 * @Security("is_granted('EXECUTE', 'cache_clear')")
 * </code>
 */
class GenericVoter extends Voter
{
    /**
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * @var \Ds\Component\Security\Collection\PermissionCollection
     */
    protected $permissionCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Service\AccessService $accessService
     * @param \Ds\Component\Security\Collection\PermissionCollection $permissionCollection
     */
    public function __construct(AccessService $accessService, PermissionCollection $permissionCollection)
    {
        $this->accessService = $accessService;
        $this->permissionCollection = $permissionCollection;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT, Permission::ADD, Permission::DELETE, Permission::EXECUTE], true)) {
            return false;
        }

        if (!is_string($subject)) {
            return false;
        }

        $permission = $this->permissionCollection->get($subject);

        if (!$permission) {
            return false;
        }

        if (Permission::GENERIC !== $permission->getType()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $subject = $this->permissionCollection->get($subject);
        $permissions = $this->accessService->getPermissions($user);

        foreach ($permissions as $permission) {
            if (Permission::GENERIC !== $permission->getType()) {
                // Skip permissions that are not of type "generic".
                continue;
            }

            if (!fnmatch($permission->getValue(), $subject->getValue(), FNM_NOESCAPE)) {
                // Skip permissions that are not related to the subject.
                // The fnmatch function is used to match asterisk patterns.
                continue;
            }

            if (in_array($attribute, $permission->getAttributes(), true)) {
                return true;
            }
        }

        return false;
    }
}
