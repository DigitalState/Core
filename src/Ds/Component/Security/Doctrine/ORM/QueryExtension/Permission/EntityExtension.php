<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension\Permission;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Security\Model\Permission;
use Ds\Component\Security\Service\AccessService;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class EntityExtension
 *
 * @package Ds\Component\Security
 */
class EntityExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
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
        $this->apply($queryBuilder, $resourceClass, Permission::BROWSE);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->apply($queryBuilder, $resourceClass, Permission::READ);
    }

    /**
     * Apply condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    protected function apply(QueryBuilder $queryBuilder, string $resourceClass, string $attribute)
    {
        if (!in_array(Ownable::class, class_implements($resourceClass), true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return;
        }

        $user = $token->getUser();
        $permissions = $this->accessService->getCompiled($user);
        $ownerUuids = [];

        foreach ($permissions as $permission) {
            if ('BusinessUnit' !== $permission->getEntity()) {
                continue;
            }

            if (Permission::ENTITY !== $permission->getType()) {
                continue;
            }

            if ('*' !== $permission->getValue() && $resourceClass !== $permission->getValue()) {
                continue;
            }

            if (!in_array($attribute, $permission->getAttributes(), true)) {
                continue;
            }

            $ownerUuids[] = $permission->getEntityUuid();
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->andWhere(sprintf('%s.owner = :owner', $rootAlias))
            ->setParameter('owner', 'BusinessUnit');

        if (in_array(null, $ownerUuids, true)) {
            return;
        }

        $queryBuilder
            ->andWhere(sprintf('%s.ownerUuid IN (:owner_uuids)', $rootAlias))
            ->setParameter('owner_uuids', $ownerUuids);
    }
}
