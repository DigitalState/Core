<?php

namespace Ds\Component\Acl\Voter;

use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Model\Permission;
use Ds\Component\Acl\Service\AccessService;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Security\Model\User;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class PropertyVoter
 *
 * @package Ds\Component\Acl
 * @example Grant access if the user can browse the object's uuid property
 * <code>
 *     @Security("is_granted('BROWSE', [object, 'uuid'])")
 * </code>
 */
final class PropertyVoter extends Voter
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
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;

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
        $this->accessor = PropertyAccess::createPropertyAccessor();
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

        if (!is_object($subject[0])) {
            return false;
        }

        $class = get_class($subject[0]);

        if (!$this->entityCollection->contains($class)) {
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

        $permissions = $this->accessService->getPermissions($user, true);

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

            $scope = $permission->getScope();
            $type = array_key_exists('type', $scope) ? $scope['type'] : null;
            $entity = array_key_exists('entity', $scope) ? $scope['entity'] : null;
            $entityUuid = array_key_exists('entity_uuid', $scope) ? $scope['entity_uuid'] : null;

            switch ($type) {
                case 'generic':
                    // Nothing to specifically validate.
                    break;

                case 'object':
                    if (!$subject instanceof Uuidentifiable) {
                        // Skip permissions with scope "object" if the subject entity is not uuidentitiable.
                        continue;
                    }

                    if ($entityUuid !== $subject->getUuid()) {
                        // Skip permissions that do not match the subject entity uuid.
                        continue;
                    }

                    break;

                case 'identity':
                    if (!$subject[0] instanceof Identitiable) {
                        // Skip permissions with scope "identity" if the subject entity is not identitiable.
                        continue;
                    }

                    if (null !== $entity) {
                        if ($entity !== $subject[0]->getIdentity()) {
                            // Skip permissions that do not match the subject entity identity.
                            continue;
                        }
                    }

                    if (null !== $entityUuid) {
                        if ($entityUuid !== $subject[0]->getIdentityUuid()) {
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

                    if (null !== $entity) {
                        if ($entity !== $subject[0]->getOwner()) {
                            // Skip permissions that do not match the subject entity owner.
                            continue;
                        }
                    }

                    if (null !== $entityUuid) {
                        if ($entityUuid !== $subject[0]->getOwnerUuid()) {
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

                case 'property':
                    $property = array_key_exists('property', $scope) ? $scope['property'] : null;
                    $value = array_key_exists('value', $scope) ? $scope['value'] : null;

                    if (null === $property) {
                        continue;
                    }

                    if (!$this->accessor->isReadable($subject, $property)) {
                        continue;
                    }

                    if (!$this->accessor->getValue($subject, $property) !== $value) {
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
