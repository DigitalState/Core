<?php

namespace Ds\Component\Security\Voter\Permission;

use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Model\Type\Secured;
use Ds\Component\Security\Service\AccessService;
use Ds\Component\Security\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PropertyVoter
 *
 * @package Ds\Component\Security
 * @example Grant access if the user can browse the object's uuid property
 * <code>
 * @Security("is_granted('BROWSE', [object, 'uuid'])")
 * </code>
 */
class PropertyVoter extends Voter
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
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT, Permission::ADD, Permission::DELETE, Permission::EXECUTE], true)) {
            return false;
        }

        if (!is_array($subject)) {
            return false;
        }

        if (2 !== count($subject)) {
            return false;
        }

        if (!array_key_exists(0, $subject)) {
            return false;
        }

        if (!$subject[0] instanceof Secured) {
            return false;
        }

        if (!array_key_exists(1, $subject)) {
            return false;
        }

        if (!is_string($subject[1])) {
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
            if (Permission::PROPERTY !== $permission->getType()) {
                // Skip permissions that are not of type "property".
                continue;
            }

            if (!fnmatch($permission->getValue(), get_class($subject[0]).'.'.$subject[1], FNM_NOESCAPE)) {
                // Skip permissions that are not related to the subject entity property.
                // The fnmatch function is used to match asterisk patterns.
                continue;
            }

            switch ($permission->getScope()) {
                case null:
                case 'class':
                    // Nothing to specifically validate, since the class property was validated above.
                    break;

                case 'object':
                    if (!$subject instanceof Uuidentifiable) {
                        // Skip permissions with scope "object" if the subject entity is not uuidentitiable.
                        continue;
                    }

                    if ($permission->getEntityUuid() !== $subject->getUuid()) {
                        // Skip permissions that do not match the subject entity uuid.
                        continue;
                    }

                    break;

                case 'identity':
                    if (!$subject[0] instanceof Identitiable) {
                        // Skip permissions with scope "identity" if the subject entity is not identitiable.
                        continue;
                    }

                    if (null !== $permission->getEntity()) {
                        if ($permission->getEntity() !== $subject[0]->getIdentity()) {
                            // Skip permissions that do not match the subject entity identity.
                            continue;
                        }
                    }

                    if (null !== $permission->getEntityUuid()) {
                        if ($permission->getEntityUuid() !== $subject[0]->getIdentityUuid()) {
                            // Skip permissions that do not match the subject entity identity uuid.
                            continue;
                        }
                    }

                    break;

                case 'owner':
                    if (!$subject[0] instanceof Ownable) {
                        // Skip permissions with scope "owner" if the subject entity is not ownable.
                        continue;
                    }

                    if (null !== $permission->getEntity()) {
                        if ($permission->getEntity() !== $subject[0]->getOwner()) {
                            // Skip permissions that do not match the subject entity owner.
                            continue;
                        }
                    }

                    if (null !== $permission->getEntityUuid()) {
                        if ($permission->getEntityUuid() !== $subject[0]->getOwnerUuid()) {
                            // Skip permissions that do not match the subject entity owner uuid.
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
