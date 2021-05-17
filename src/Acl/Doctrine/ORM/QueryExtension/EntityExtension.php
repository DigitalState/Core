<?php

namespace Ds\Component\Acl\Doctrine\ORM\QueryExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Annotations\Reader;
use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Service\AccessService;
use Ds\Component\Acl\Exception\NoPermissionsException;
use Ds\Component\Acl\Model\Permission;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Translation\Model\Annotation\Translate;
use Ds\Component\Translation\Model\Type\Translatable;
use LogicException;
use ReflectionClass;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class EntityExtension
 *
 * @package Ds\Component\Acl
 */
final class EntityExtension implements QueryCollectionExtensionInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

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
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Acl\Service\AccessService $accessService
     * @param \Ds\Component\Acl\Collection\EntityCollection $entityCollection
     * @param \Doctrine\Common\Annotations\Reader $annotationReader
     */
    public function __construct(TokenStorageInterface $tokenStorage, AccessService $accessService, EntityCollection $entityCollection, Reader $annotationReader)
    {
        $this->tokenStorage = $tokenStorage;
        $this->accessService = $accessService;
        $this->entityCollection = $entityCollection;
        $this->annotationReader = $annotationReader;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (!$this->entityCollection->contains($resourceClass)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            throw new LogicException('Token is not defined.');
        }

        $user = $token->getUser();
        $permissions = $this->accessService->getPermissions($user, true);
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $wheres = [];
        $parameters = [];
        $i = 0;

        foreach ($permissions as $permission) {
            if (Permission::ENTITY !== $permission->getType()) {
                // Skip permissions that are not of type "entity".
                continue;
            }

            if (!fnmatch($permission->getValue(), $resourceClass, FNM_NOESCAPE)) {
                // Skip permissions that are not related to the entity.
                // The fnmatch function is used to match asterisk patterns.
                continue;
            }

            if (!in_array(Permission::BROWSE, $permission->getAttributes(), true)) {
                // Skip permissions that do not have the required attribute.
                continue;
            }

            $operator = $permission->getScopeOperator();
            $conditions = $permission->getScopeConditions();
            $subWheres = [];

            foreach ($conditions as $condition) {
                $type = isset($condition['type']) ? $condition['type'] : null;

                switch ($type) {
                    case 'generic':
                        // This permission grants access to all entities of the class, no where conditions need to be applied.
                        return;

                    case 'object':
                        if (!in_array(Uuidentifiable::class, class_implements($resourceClass), true)) {
                            // Skip permissions with scope "object" if the entity is not uuidentifiable.
                            continue;
                        }

                        if (!isset($condition['entity_uuid'])) {
                            // Skip permissions without entity_uuid defined.
                            continue;
                        }

                        $subWheres[] = $queryBuilder->expr()->eq($rootAlias . '.uuid', ':ds_security_uuid_' . $i);
                        $parameters['ds_security_uuid_' . $i] = $condition['entity_uuid'];
                        $i++;

                        break;

                    case 'identity':
                        if (!in_array(Identitiable::class, class_implements($resourceClass), true)) {
                            // Skip permissions with scope "identity" if the entity is not identitiable.
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

                        if (in_array($resourceClass, [
                            'App\\Entity\\Anonymous',
                            'App\\Entity\\Individual',
                            'App\\Entity\\Organization',
                            'App\\Entity\\Staff'
                        ])) {
                            $subWheres[] = $queryBuilder->expr()->eq($rootAlias . '.uuid', ':ds_security_identity_' . $i);
                            $parameters['ds_security_identity_' . $i] = $condition['entity_uuid'];
                        } else if (in_array($resourceClass, [
                            'App\\Entity\\AnonymousPersona',
                            'App\\Entity\\IndividualPersona',
                            'App\\Entity\\OrganizationPersona',
                            'App\\Entity\\StaffPersona'
                        ])) {
                            $identity = substr($resourceClass, 0, -7);
                            $alias = strtolower(substr($resourceClass, 17, -7));
                            $subQueryBuilder = new QueryBuilder($queryBuilder->getEntityManager());
                            $subWheres[] = $queryBuilder->expr()->in(
                                $rootAlias . '.' . $alias,
                                $subQueryBuilder
                                    ->select($alias)
                                    ->from($identity, $alias)
                                    ->where($alias . '.uuid = :ds_security_identity_uuid_' . $i)
                                    ->getDQL()
                            );
                            $parameters['ds_security_identity_uuid_' . $i] = $condition['entity_uuid'];
                        } else {
                            $subWheres[] = $queryBuilder->expr()->andX(
                                $queryBuilder->expr()->eq($rootAlias . '.identity', ':ds_security_identity_' . $i),
                                $queryBuilder->expr()->eq($rootAlias . '.identityUuid', ':ds_security_identity_uuid_' . $i)
                            );
                            $parameters['ds_security_identity_' . $i] = $condition['entity'];
                            $parameters['ds_security_identity_uuid_' . $i] = $condition['entity_entity'];
                        }

                        $i++;

                        break;

                    case 'owner':
                        if (!in_array(Ownable::class, class_implements($resourceClass), true)) {
                            // Skip permissions with scope "owner" if the entity is not ownable.
                            continue;
                        }

                        if (!isset($condition['entity'])) {
                            // Skip permissions without entity defined.
                            continue;
                        }

                        $entityUuid = isset($condition['entity_uuid']) ? $condition['entity_uuid'] : null;

                        if (null === $entityUuid) {
                            $subWheres[] = $queryBuilder->expr()->eq($rootAlias . '.owner', ':ds_security_owner_' . $i);
                            $parameters['ds_security_owner_' . $i] = $condition['entity'];
                        } else {
                            $subWheres[] = $queryBuilder->expr()->andX(
                                $queryBuilder->expr()->eq($rootAlias . '.owner', ':ds_security_owner_' . $i),
                                $queryBuilder->expr()->eq($rootAlias . '.ownerUuid', ':ds_security_owner_uuid_' . $i)
                            );
                            $parameters['ds_security_owner_' . $i] = $condition['entity'];
                            $parameters['ds_security_owner_uuid_' . $i] = $entityUuid;
                        }

                        $i++;

                        break;

                    case 'session':
                        if (!in_array(Identitiable::class, class_implements($resourceClass), true)) {
                            // Skip permissions with scope "session" if the entity is not identitiable.
                            continue;
                        }

                        // @todo Refactor this exception handling at the entity level with metadata, the core should not know about these details.
                        if (in_array($resourceClass, [
                            'App\\Entity\\Anonymous',
                            'App\\Entity\\Individual',
                            'App\\Entity\\Organization',
                            'App\\Entity\\Staff'
                        ])) {
                            $subWheres[] = $queryBuilder->expr()->eq($rootAlias . '.uuid', ':ds_security_identity_uuid_' . $i);
                            $parameters['ds_security_identity_uuid_' . $i] = $user->getIdentity()->getUuid();
                        } else if (in_array($resourceClass, [
                            'App\\Entity\\AnonymousPersona',
                            'App\\Entity\\IndividualPersona',
                            'App\\Entity\\OrganizationPersona',
                            'App\\Entity\\StaffPersona'
                        ])) {
                            $identity = substr($resourceClass, 0, -7);
                            $alias = strtolower(substr($resourceClass, 17, -7));
                            $subQueryBuilder = new QueryBuilder($queryBuilder->getEntityManager());
                            $subWheres[] = $queryBuilder->expr()->in(
                                $rootAlias . '.' . $alias,
                                $subQueryBuilder
                                    ->select($alias)
                                    ->from($identity, $alias)
                                    ->where($alias . '.uuid = :ds_security_identity_uuid_' . $i)
                                    ->getDQL()
                            );
                            $parameters['ds_security_identity_uuid_' . $i] = $user->getIdentity()->getUuid();
                        } else {
                            $subWheres[] = $queryBuilder->expr()->andX(
                                $queryBuilder->expr()->eq($rootAlias . '.identity', ':ds_security_identity_' . $i),
                                $queryBuilder->expr()->eq($rootAlias . '.identityUuid', ':ds_security_identity_uuid_' . $i)
                            );
                            $parameters['ds_security_identity_' . $i] = $user->getIdentity()->getType();
                            $parameters['ds_security_identity_uuid_' . $i] = $user->getIdentity()->getUuid();
                        }

                        $i++;

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

                        if (!property_exists($resourceClass, $property)) {
                            // Skip permissions that do not specify an existing property on the entity.
                            continue;
                        }

                        $field = $this->getField($resourceClass, $property);

                        if ('translation.scalar' === $field) {
                            if (count($parts) !== 1) {
                                // Skip permissions that do not specify a language and a json path.
                                continue;
                            }

                            $locale = array_shift($parts);
                            $translationAlias = $this->addJoinTranslation($queryBuilder, $resourceClass, $locale, $i);
                            $i++;

                            if (null === $value) {
                                if ('eq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNull($translationAlias . '.' . $property);
                                } else if ('neq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNotNull($translationAlias . '.' . $property);
                                }
                            } else {
                                $subWheres[] = $queryBuilder->expr()->{$comparison}($translationAlias . '.' . $property, ':ds_security_property_' . $i);

                                if ('like' === $comparison) {
                                    $parameters['ds_security_property_' . $i] = '%' . $value . '%';
                                } else {
                                    $parameters['ds_security_property_' . $i] = $value;
                                }
                            }
                        } else if ('translation.json' === $field) {
                            if (count($parts) !== 2) {
                                // Skip permissions that do not specify a language and a json path.
                                continue;
                            }

                            $locale = array_shift($parts);
                            $path = implode('.', $parts);
                            $translationAlias = $this->addJoinTranslation($queryBuilder, $resourceClass, $locale, $i);
                            $i++;
                            $value = $this->typeCast($value);

                            if (false !== strpos($path, '.')) {
                                $operand = 'JSON_GET_PATH_TEXT(' . $translationAlias . '.' . $property . ', \'{' . str_replace('.', ', ', $path) . '}\')';
                            } else {
                                $operand = 'JSON_GET_TEXT(' . $translationAlias . '.' . $property . ', \'' . $path . '\')';
                            }

                            if (null === $value) {
                                if ('eq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNull($operand);
                                } else if ('neq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNotNull($operand);
                                }
                            } else {
                                $subWheres[] = $queryBuilder->expr()->{$comparison}($operand, ':ds_security_property_' . $i);

                                if ('like' === $comparison) {
                                    $parameters['ds_security_property_' . $i] = '%' . $value . '%';
                                } else {
                                    $parameters['ds_security_property_' . $i] = $value;
                                }
                            }
                        } else if ('json' === $field) {
                            if (count($parts) !== 1) {
                                // Skip permissions that do not specify json path.
                                continue;
                            }

                            $path = implode('.', $parts);
                            $value = $this->typeCast($value);

                            if (false !== strpos($path, '.')) {
                                $operand = 'JSON_GET_PATH_TEXT(' . $rootAlias . '.' . $property . ', \'{' . str_replace('.', ', ', $path) . '}\')';
                            } else {
                                $operand = 'JSON_GET_TEXT(' . $rootAlias . '.' . $property . ', \'' . $path . '\')';
                            }

                            if (null === $value) {
                                if ('eq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNull($operand);
                                } else if ('neq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNotNull($operand);
                                }
                            } else {
                                $subWheres[] = $queryBuilder->expr()->{$comparison}($operand, ':ds_security_property_' . $i);

                                if ('like' === $comparison) {
                                    $parameters['ds_security_property_' . $i] = '%' . $value . '%';
                                } else {
                                    $parameters['ds_security_property_' . $i] = $value;
                                }
                            }
                        } else if ('scalar' === $field) {
                            if (count($parts) !== 0) {
                                // Skip permissions that do not specify an existing property on the entity.
                                continue;
                            }

                            if (null === $value) {
                                if ('eq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNull($rootAlias . '.' . $property);
                                } else if ('neq' === $comparison) {
                                    $subWheres[] = $queryBuilder->expr()->isNotNull($rootAlias . '.' . $property);
                                }
                            } else {
                                $subWheres[] = $queryBuilder->expr()->{$comparison}($rootAlias . '.' . $property, ':ds_security_property_' . $i);

                                if ('like' === $comparison) {
                                    $parameters['ds_security_property_' . $i] = '%' . $value . '%';
                                } else {
                                    $parameters['ds_security_property_' . $i] = $value;
                                }
                            }
                        }

                        $i++;

                        break;

                    default:
                        // Skip permissions with unknown scopes. In theory, this case should never
                        // be selected unless there are data integrity issues.
                        // @todo Add notice logs
                        continue;
                }
            }

            if ($subWheres) {
                $wheres[] = call_user_func_array([$queryBuilder->expr(), $operator . 'X'], $subWheres);
            }
        }

        if (!$wheres) {
            throw new NoPermissionsException;
        }

        $queryBuilder->andWhere(call_user_func_array([$queryBuilder->expr(), 'orX'], $wheres));

        foreach ($parameters as $key => $value) {
            $queryBuilder->setParameter($key, $value);
        }
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

    /**
     * Add a translation join entry, if not already present
     *
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     * @param string $locale
     * @param integer $i
     * @return string
     */
    private function addJoinTranslation(QueryBuilder $queryBuilder, string $resourceClass, string $locale, int $i): string
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $translationAlias = $rootAlias . '_t_' . $i;
        $parts = $queryBuilder->getDQLParts()['join'];

        foreach ($parts as $joins) {
            foreach ($joins as $join) {
                if ($translationAlias === $join->getAlias()) {
                    return $translationAlias;
                }
            }
        }

        $queryBuilder->innerJoin($rootAlias . '.translations', $translationAlias/*,  'WITH', $translationAlias . '.locale = :ds_security_locale'*/);
        $queryBuilder->andWhere($translationAlias . '.locale = :ds_security_translation_' . $i);
        $queryBuilder->setParameter('ds_security_translation_' . $i, $locale);

        return $translationAlias;
    }

    /**
     * Type cast value for database JSON_GET_TEXT
     *
     * @param mixed $value
     * @return mixed
     */
    private function typeCast($value)
    {
        if ('string' === gettype($value)) {
            // Nothing to do.
        } else if ('boolean' === gettype($value)) {
            $value = $value ? 'true' : 'false';
        } else if ('integer' === gettype($value)) {
            $value = (string) $value;
        } else if ('double' === gettype($value)) {
            $value = (string) $value;
        } else if ('NULL' === gettype($value)) {
            // Nothing to do.
        }

        return $value;
    }
}
