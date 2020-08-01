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

        $permissions = $this->accessService->getPermissions($user, true);

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

            if (!in_array($attribute, $permission->getAttributes(), true)) {
                // Skip permissions that do not contain the required attribute.
                continue;
            }

            $operator = $permission->getScopeOperator();
            $conditions = $permission->getScopeConditions();
            $results = [];

            foreach ($conditions as $condition) {
                $result = null;
                $type = isset($condition['type']) ? $condition['type'] : null;

                switch ($type) {
                    case 'generic':
                        // Nothing to specifically validate.
                        $result = true;
                        break;

                    case 'object':
                        if (!$subject instanceof Uuidentifiable) {
                            // Skip permissions with scope "object" if the subject entity is not uuidentitiable.
                            continue;
                        }

                        if (!isset($condition['entity_uuid'])) {
                            // Skip permissions without entity_uuid defined.
                            continue;
                        }

                        $result = true;

                        if ($condition['entity_uuid'] !== $subject->getUuid()) {
                            $result = false;
                        }

                        break;

                    case 'identity':
                        if (!$subject instanceof Identitiable) {
                            // Skip permissions with scope "identity" if the subject entity is not identitiable.
                            continue;
                        }

                        if (!isset($condition['entity'])) {
                            // Skip permissions without entity defined.
                            continue;
                        }

                        if (!isset($condition['entity_uuid'])) {
                            // Skip permissions without entity_uuid defined.
                            continue;
                        }

                        $result = true;

                        if ($condition['entity'] !== $subject->getIdentity()) {
                            $result = false;
                        }

                        if ($condition['entity_uuid'] !== $subject->getIdentityUuid()) {
                            $result = false;
                        }

                        break;

                    case 'owner':
                        if (!$subject instanceof Ownable) {
                            // Skip permissions with scope "owner" if the subject entity is not ownable.
                            continue;
                        }

                        if (!isset($condition['entity'])) {
                            // Skip permissions without entity defined.
                            continue;
                        }

                        $result = true;

                        if ($condition['entity'] !== $subject->getOwner()) {
                            $result = false;
                        }

                        if (isset($condition['entity_uuid'])) {
                            if ($condition['entity_uuid'] !== $subject->getOwnerUuid()) {
                                $result = false;
                            }
                        }

                        break;

                    case 'session':
                        if (!$subject instanceof Identitiable) {
                            // Skip permissions with scope "session" if the subject entity is not identitiable.
                            continue;
                        }

                        $result = true;

                        if ($user->getIdentity()->getType() !== $subject->getIdentity()) {
                            $result = false;
                        }

                        if ($user->getIdentity()->getUuid() !== $subject->getIdentityUuid()) {
                            $result = false;
                        }

                        break;

                    case 'property':
                        $property = isset($condition['property']) ? $condition['property'] : null;
                        $value = isset($condition['value']) ? $condition['value'] : null;
                        $comparison = isset($condition['comparison']) ? $condition['comparison'] : 'eq';

                        if (null === $property) {
                            // Skip permissions that do not define a property.
                            continue;
                        }

                        if (!in_array($comparison, ['eq', 'neq'], true)) {
                            // Skip permissions that do not have supported comparison types.
                            continue;
                        }

                        if (!in_array(gettype($value), ['string', 'boolean', 'integer', 'double', 'NULL'], true)) {
                            // Skip permissions that do not have supported value types.
                            continue;
                        }

                        $parts = explode('.', $property);
                        $property = array_shift($parts);
                        $path = str_replace('\'', '', implode('.', $parts));

                        if (!property_exists($subject, $property)) {
                            // Skip permissions that contains an unreadable property.
                            continue;
                        }

                        $result = true;

                        if ('' !== $path) {
                            $property .= '.' . $path;
                        }

                        if (!$this->accessor->isReadable($subject, $property)) {
                            $result = false;
                        }

                        if ('eq' === $comparison) {
                            if ($this->accessor->getValue($subject, $property) !== $value) {
                                $result = false;
                            }
                        } else if ('neq' === $comparison) {
                            if ($this->accessor->getValue($subject, $property) === $value) {
                                $result = false;
                            }
                        }

                        break;

                    default:
                        // Skip permissions with unknown scopes. In theory, this case should never
                        // be selected unless there are data integrity issues.
                        // @todo Add notice logs
                        continue;
                }

                if (null !== $result) {
                    $results[] = $result;
                }
            }

            if (!$results) {
                // Skip permissions that yields no results.
                continue;
            }

            if ('and' === $operator && !in_array(false, $results, true)) {
                // All results must be true.
                return true;
            }

            if ('or' === $operator && in_array(true, $results, true)) {
                // At least one result must be true.
                return true;
            }
        }

        return false;
    }
}
