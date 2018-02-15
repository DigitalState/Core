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
        $applicable = false;
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
                case null:
                case 'class':
                    $conditions[] = $queryBuilder->expr()->eq('class', 'class');
                    break;

                case 'object':
                    if (!in_array(Uuidentifiable::class, class_implements($resourceClass), true)) {
                        // Skip permissions with scope "object" if the entity is not uuidentifiable.
                        continue;
                    }

                    $conditions[] = $queryBuilder->expr()->eq(sprintf('%s.uuid', $rootAlias), ':uuid'.$i);
                    $parameters['uuid'.$i] = $permission->getEntityUuid();
                    $i++;

                    break;

                case 'identity':
                    if (!in_array(Identitiable::class, class_implements($resourceClass), true)) {
                        // Skip permissions with scope "identity" if the entity is not identitiable.
                        continue;
                    }

                    if (null === $permission->getEntityUuid()) {
                        $conditions[] = $queryBuilder->expr()->eq(sprintf('%s.identity', $rootAlias), ':identity'.$i);
                        $parameters['identity'.$i] = $permission->getEntity();
                    } else {
                        $conditions[] = $queryBuilder->expr()->andX(
                            $queryBuilder->expr()->eq(sprintf('%s.identity', $rootAlias), ':identity'.$i),
                            $queryBuilder->expr()->eq(sprintf('%s.identityUuid', $rootAlias), ':identityUuid'.$i)
                        );
                        $parameters['identity'.$i] = $permission->getEntity();
                        $parameters['identityUuid'.$i] = $permission->getEntityUuid();
                    }

                    $i++;

                    break;

                case 'owner':
                    if (!in_array(Ownable::class, class_implements($resourceClass), true)) {
                        // Skip permissions with scope "owner" if the entity is not ownable.
                        continue;
                    }

                    if (null === $permission->getEntityUuid()) {
                        $conditions[] = $queryBuilder->expr()->eq(sprintf('%s.owner', $rootAlias), ':owner'.$i);
                        $parameters['owner'.$i] = $permission->getEntity();
                    } else {
                        $conditions[] = $queryBuilder->expr()->andX(
                            $queryBuilder->expr()->eq(sprintf('%s.owner', $rootAlias), ':owner'.$i),
                            $queryBuilder->expr()->eq(sprintf('%s.ownerUuid', $rootAlias), ':ownerUuid'.$i)
                        );
                        $parameters['owner'.$i] = $permission->getEntity();
                        $parameters['ownerUuid'.$i] = $permission->getEntityUuid();
                    }

                    $i++;

                    break;
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
