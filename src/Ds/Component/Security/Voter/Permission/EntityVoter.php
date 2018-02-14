<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Model\Type\Secured;
use Ds\Component\Security\Service\AccessService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class EntityVoter
 *
 * @package Ds\Component\Security
 */
class EntityVoter extends Voter
{
    /**
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Service\AccessService $accessService
     */
    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    /**
     * {@inheritdoc}
     * @example
     * <code>
     * is_granted("BROWSE", \Ds\Component\Security\Model\Type\Secured $object)
     * </code>
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT, Permission::ADD, Permission::DELETE, Permission::EXECUTE], true)) {
            return false;
        }

        if (!$subject instanceof Secured) {
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

        $permissions = $this->accessService->getPermissions($user);

        foreach ($permissions as $permission) {
            if (Permission::ENTITY !== $permission->getType()) {
                // Skip permissions that are not of type "entity".
                continue;
            }

            if (!fnmatch($permission->getValue(), get_class($subject), FNM_NOESCAPE)) {
                // Skip permissions that are not related to the subject entity.
                // The fnmatch function is used to match asterisk patterns.
                continue;
            }

            switch ($permission->getScope()) {
                case 'identity':
                    if (!$subject instanceof Identitiable) {
                        // Skip permissions with scope "identity" if the subject entity is not identitiable.
                        continue;
                    }

                    if (null !== $permission->getEntity()) {
                        if ($permission->getEntity() !== $subject->getIdentity()) {
                            // Skip permissions that do not match the identity field.
                            continue;
                        }
                    }

                    if (null !== $permission->getEntityUuid()) {
                        if ($permission->getEntityUuid() !== $subject->getIdentityUuid()) {
                            // Skip permissions that do not match the identity uuid field.
                            continue;
                        }
                    }

                    break;

                case 'owner':
                    if (!$subject instanceof Ownable) {
                        // Skip permissions with scope "owner" if the subject entity is not ownable.
                        continue;
                    }

                    if (null !== $permission->getEntity()) {
                        if ($permission->getEntity() !== $subject->getOwner()) {
                            // Skip permissions that do not match the owner field.
                            continue;
                        }
                    }

                    if (null !== $permission->getEntityUuid()) {
                        if ($permission->getEntityUuid() !== $subject->getOwnerUuid()) {
                            // Skip permissions that do not match the owner uuid field.
                            continue;
                        }
                    }

                    break;
            }

            if (in_array($attribute, $permission->getAttributes(), true)) {
                return true;
            }
        }

        return false;
    }
}
