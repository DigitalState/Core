<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension\Permission;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Security\Exception\NoPermissionsException;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Model\Type\Secured;
use Ds\Component\Security\Service\AccessService;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class EntityExtension
 *
 * @package Ds\Component\Security
 */
class EntityExtension implements QueryCollectionExtensionInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Security\Service\AccessService
     */
    protected $accessService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Security\Service\AccessService $accessService
     */
    public function __construct(TokenStorageInterface $tokenStorage, AccessService $accessService)
    {
        $this->tokenStorage = $tokenStorage;
        $this->accessService = $accessService;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (!in_array(Secured::class, class_implements($resourceClass), true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            throw new LogicException('Token is not defined.');
        }

        $user = $token->getUser();
        $permissions = $this->accessService->getPermissions($user);
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $conditions = [];
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

            switch ($permission->getScope()) {
                case 'generic':
                    // This permission grants access to all entities of the class, no conditions need to be applied.
                    return;

                case 'object':
                    if (!in_array(Uuidentifiable::class, class_implements($resourceClass), true)) {
                        // Skip permissions with scope "object" if the entity is not uuidentifiable.
                        continue;
                    }

                    $conditions[] = $queryBuilder->expr()->eq($rootAlias.'.uuid', ':ds_uuid_'.$i);
                    $parameters['ds_uuid_'.$i] = $permission->getEntityUuid();
                    $i++;

                    break;

                case 'identity':
                    if (!in_array(Identitiable::class, class_implements($resourceClass), true)) {
                        // Skip permissions with scope "identity" if the entity is not identitiable.
                        continue;
                    }

                    if (in_array($resourceClass, [
                        'AppBundle\\Entity\\Anonymous',
                        'AppBundle\\Entity\\Individual',
                        'AppBundle\\Entity\\Organization',
                        'AppBundle\\Entity\\Staff'
                    ])) {
                        $conditions[] = $queryBuilder->expr()->eq($rootAlias.'.uuid', ':ds_identity_'.$i);
                        $parameters['ds_identity_'.$i] = $permission->getEntity();
                    } else if (in_array($resourceClass, [
                        'AppBundle\\Entity\\AnonymousPersona',
                        'AppBundle\\Entity\\IndividualPersona',
                        'AppBundle\\Entity\\OrganizationPersona',
                        'AppBundle\\Entity\\StaffPersona'
                    ])) {
                        $identity = substr($resourceClass, 0, -7);
                        $alias = strtolower(substr($resourceClass, 17, -7));
                        $subQueryBuilder = new QueryBuilder($queryBuilder->getEntityManager());
                        $conditions[] = $queryBuilder->expr()->in(
                            $rootAlias.'.'.$alias,
                            $subQueryBuilder
                                ->select($alias)
                                ->from($identity, $alias)
                                ->where($alias.'.uuid = :ds_identity_uuid_'.$i)
                                ->getDQL()
                        );
                        $parameters['ds_identity_uuid_'.$i] = $permission->getEntityUuid();
                    } else {
                        $conditions[] = $queryBuilder->expr()->andX(
                            $queryBuilder->expr()->eq($rootAlias.'.identity', ':ds_identity_'.$i),
                            $queryBuilder->expr()->eq($rootAlias.'.identityUuid', ':ds_identity_uuid_'.$i)
                        );
                        $parameters['ds_identity_'.$i] = $permission->getEntity();
                        $parameters['ds_identity_uuid_'.$i] = $permission->getEntityUuid();
                    }

                    $i++;

                    break;

                case 'owner':
                    if (!in_array(Ownable::class, class_implements($resourceClass), true)) {
                        // Skip permissions with scope "owner" if the entity is not ownable.
                        continue;
                    }

                    if (null === $permission->getEntityUuid()) {
                        $conditions[] = $queryBuilder->expr()->eq($rootAlias.'.owner', ':ds_owner_'.$i);
                        $parameters['ds_owner_'.$i] = $permission->getEntity();
                    } else {
                        $conditions[] = $queryBuilder->expr()->andX(
                            $queryBuilder->expr()->eq($rootAlias.'.owner', ':ds_owner_'.$i),
                            $queryBuilder->expr()->eq($rootAlias.'.ownerUuid', ':ds_owner_uuid_'.$i)
                        );
                        $parameters['ds_owner_'.$i] = $permission->getEntity();
                        $parameters['ds_owner_uuid_'.$i] = $permission->getEntityUuid();
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
                        'AppBundle\\Entity\\Anonymous',
                        'AppBundle\\Entity\\Individual',
                        'AppBundle\\Entity\\Organization',
                        'AppBundle\\Entity\\Staff'
                    ])) {
                        $conditions[] = $queryBuilder->expr()->eq($rootAlias.'.uuid', ':ds_identity_uuid_'.$i);
                        $parameters['ds_identity_uuid_'.$i] = $user->getIdentityUuid();
                    } else if (in_array($resourceClass, [
                        'AppBundle\\Entity\\AnonymousPersona',
                        'AppBundle\\Entity\\IndividualPersona',
                        'AppBundle\\Entity\\OrganizationPersona',
                        'AppBundle\\Entity\\StaffPersona'
                    ])) {
                        $identity = substr($resourceClass, 0, -7);
                        $alias = strtolower(substr($resourceClass, 17, -7));
                        $subQueryBuilder = new QueryBuilder($queryBuilder->getEntityManager());
                        $conditions[] = $queryBuilder->expr()->in(
                            $rootAlias.'.'.$alias,
                            $subQueryBuilder
                                ->select($alias)
                                ->from($identity, $alias)
                                ->where($alias.'.uuid = :ds_identity_uuid_'.$i)
                                ->getDQL()
                        );
                        $parameters['ds_identity_uuid_'.$i] = $user->getIdentityUuid();
                    } else {
                        $conditions[] = $queryBuilder->expr()->andX(
                            $queryBuilder->expr()->eq($rootAlias.'.identity', ':ds_identity_'.$i),
                            $queryBuilder->expr()->eq($rootAlias.'.identityUuid', ':ds_identity_uuid_'.$i)
                        );
                        $parameters['ds_identity_'.$i] = $user->getIdentity();
                        $parameters['ds_identity_uuid_'.$i] = $user->getIdentityUuid();
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

        if (!$conditions) {
            throw new NoPermissionsException;
        }

        $queryBuilder->andWhere(call_user_func_array([$queryBuilder->expr(), 'orX'], $conditions));

        foreach ($parameters as $key => $value) {
            $queryBuilder->setParameter($key, $value);
        }
    }
}
