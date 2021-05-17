<?php

namespace Ds\Component\Acl\Voter;

use Doctrine\Common\Annotations\Reader;
use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Model\Permission;
use Ds\Component\Acl\Service\AccessService;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Security\Model\User;
use Ds\Component\Translation\Model\Annotation\Translate;
use Ds\Component\Translation\Model\Type\Translatable;
use ReflectionClass;
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
     * @var \Doctrine\Common\Annotations\Reader
     */
    private $annotationReader;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;

    /**
     * Constructor
     *
     * @param \Ds\Component\Acl\Service\AccessService $accessService
     * @param \Ds\Component\Acl\Collection\EntityCollection $entityCollection
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     */
    public function __construct(AccessService $accessService, EntityCollection $entityCollection, Reader $annotationReader)
    {
        $this->accessService = $accessService;
        $this->entityCollection = $entityCollection;
        $this->annotationReader = $annotationReader;
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
                        if (!$subject[0] instanceof Uuidentifiable) {
                            // Skip permissions with scope "object" if the subject entity is not uuidentitiable.
                            continue;
                        }

                        if (!isset($condition['entity_uuid'])) {
                            // Skip permissions without entity_uuid defined.
                            continue;
                        }

                        $result = true;

                        if ($condition['entity_uuid'] !== $subject[0]->getUuid()) {
                            $result = false;
                        }

                        break;

                    case 'identity':
                        if (!$subject[0] instanceof Identitiable) {
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

                        if ($condition['entity'] !== $subject[0]->getIdentity()) {
                            $result = false;
                        }

                        if ($condition['entity_uuid'] !== $subject[0]->getIdentityUuid()) {
                            $result = false;
                        }

                        break;

                    case 'owner':
                        if (!$subject[0] instanceof Ownable) {
                            // Skip permissions with scope "owner" if the subject entity is not ownable.
                            continue;
                        }

                        if (!isset($condition['entity'])) {
                            // Skip permissions without entity defined.
                            continue;
                        }

                        $result = true;

                        if ($condition['entity'] !== $subject[0]->getOwner()) {
                            $result = false;
                        }

                        if (isset($condition['entity_uuid'])) {
                            if ($condition['entity_uuid'] !== $subject[0]->getOwnerUuid()) {
                                $result = false;
                            }
                        }

                        break;

                    case 'session':
                        if (!$subject[0] instanceof Identitiable) {
                            // Skip permissions with scope "session" if the subject entity is not identitiable.
                            continue;
                        }

                        $result = true;

                        if ($user->getIdentity()->getType() !== $subject[0]->getIdentity()) {
                            $result = false;
                        }

                        if ($user->getIdentity()->getUuid() !== $subject[0]->getIdentityUuid()) {
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

                        if (!in_array($comparison, ['eq', 'neq', 'like'], true)) {
                            // Skip permissions that do not have supported comparison types.
                            continue;
                        }

                        if (!in_array(gettype($value), ['string', 'boolean', 'integer', 'double', 'NULL'], true)) {
                            // Skip permissions that do not have supported value types.
                            continue;
                        }

                        if ('like' === $comparison && null === $value) {
                            // Skip permissions that do not have a supported values against certain comparisons.
                            continue;
                        }

                        $parts = explode('.', $property);
                        $property = array_shift($parts);
                        $path = str_replace('\'', '', implode('.', $parts));

                        if (!property_exists($subject[0], $property)) {
                            // Skip permissions that contains an unreadable property.
                            continue;
                        }

                        $field = $this->getField(get_class($subject[0]), $property);
                        $result = true;

                        if ('' !== $path) {
                            if ('translation.scalar' === $field) {
                                $property .= '[' . $path . ']';
                            } else if ('json' === $field || 'translation.json' === $field) {
                                $property .= '[' . str_replace('.', '][', $path) . ']';
                            } else {
                                $property .= '.' . $path;
                            }
                        }

                        if (!$this->accessor->isReadable($subject[0], $property)) {
                            $result = false;
                        }

                        if ('eq' === $comparison) {
                            if ($this->accessor->getValue($subject[0], $property) !== $value) {
                                $result = false;
                            }
                        } else if ('neq' === $comparison) {
                            if ($this->accessor->getValue($subject[0], $property) === $value) {
                                $result = false;
                            }
                        } else if ('like' === $comparison) {
                            $needle = (string) $value;
                            $haystack = (string) $this->accessor->getValue($subject[0], $property);

                            if (false === strpos($haystack, $needle)) {
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

    /**
     * Determine what type of field the resource class property is.
     *
     * @param $resourceClass
     * @param $property
     * @return string
     * @throws
     */
    private function getField($resourceClass, $property): ?string
    {
        $manager = $this->accessService->getManager();
        $reflection = new ReflectionClass($resourceClass);
        $reflectionProperty = $reflection->getProperty($property);
        $translatable = in_array(Translatable::class, class_implements($resourceClass));
        $annotation = $this->annotationReader->getPropertyAnnotation($reflectionProperty, Translate::class);

        if ($translatable && $annotation) {
            $translationClass = call_user_func($resourceClass . '::getTranslationEntityClass');
            $field = $this->getField($translationClass, $property);

            switch ($field) {
                case null:
                    return null;

                case 'json':
                    return 'translation.json';

                default:
                    return 'translation.scalar';
            }
        }

        $meta = $manager->getClassMetadata($resourceClass);

        if (!$meta->hasField($property)) {
            return null;
        }

        if ('json_array' === $meta->getFieldMapping($property)['type']) {
            return 'json';
        }

        return 'scalar';
    }
}
