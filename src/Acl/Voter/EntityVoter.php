<?php

namespace Ds\Component\Acl\Voter;

use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Model\Permission;
use Ds\Component\Acl\Service\AccessService;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Security\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class EntityVoter
 *
 * @package Ds\Component\Acl
 * @example
 * <code>
 *     @Security("is_granted('BROWSE', object)")
 * </code>
 */
final class EntityVoter extends Voter
{
    /**
     * @var \Ds\Component\Acl\Service\AccessService
     */
    private $accessService;

    /**
     * @var \Ds\Component\Acl\Collection\EntityCollection
     */
    private $entityCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Acl\Service\AccessService $accessService
     * @param \Ds\Component\Acl\Collection\EntityCollection $entityCollection
     */
    public function __construct(AccessService $accessService, EntityCollection $entityCollection)
    {
        $this->accessService = $accessService;
        $this->entityCollection = $entityCollection;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [Permission::BROWSE, Permission::READ, Permission::EDIT, Permission::ADD, Permission::DELETE, Permission::EXECUTE], true)) {
            return false;
        }

        if (!is_object($subject)) {
            return false;
        }

        $class = get_class($subject);

        if (!$this->entityCollection->contains($class)) {
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
                case 'generic':
                    // Nothing to specifically validate.
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
                    if (!$subject instanceof Identitiable) {
                        // Skip permissions with scope "identity" if the subject entity is not identitiable.
                        continue;
                    }

                    if (null !== $permission->getEntity()) {
                        if ($permission->getEntity() !== $subject->getIdentity()) {
                            // Skip permissions that do not match the subject entity identity.
                            continue;
                        }
                    }

                    if (null !== $permission->getEntityUuid()) {
                        if ($permission->getEntityUuid() !== $subject->getIdentityUuid()) {
                            // Skip permissions that do not match the subject entity identity uuid.
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
                            // Skip permissions that do not match the subject entity owner.
                            continue;
                        }
                    }

                    if (null !== $permission->getEntityUuid()) {
                        if ($permission->getEntityUuid() !== $subject->getOwnerUuid()) {
                            // Skip permissions that do not match the subject entity owner uuid.
                            continue;
                        }
                    }

                    break;

                case 'session':
                    if (!$subject instanceof Identitiable) {
                        // Skip permissions with scope "session" if the subject entity is not identitiable.
                        continue;
                    }

                    if ($user->getIdentity()->getType() !== $subject->getIdentity()) {
                        // Skip permissions that do not match the subject entity identity.
                        continue;
                    }

                    if ($user->getIdentity()->getUuid() !== $subject->getIdentityUuid()) {
                        // Skip permissions that do not match the subject entity identity uuid.
                        continue;
                    }

                    break;

                default:
                    // Skip permissions with unknown scopes. In theory, this case should never
                    // be selected unless there are data integrity issues.
                    // @todo Add notice logs
                    continue;
            }

            if (in_array($attribute, $permission->getAttributes(), true)) {
                return true;
            }
        }

        return false;
    }
}
