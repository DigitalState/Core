<?php

namespace Ds\Component\Security\Doctrine\ORM\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Ds\Component\Security\Security\User\User;

/**
 * Class OwnerExtension
 */
class OwnerExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var string
     */
    protected $entity;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    protected $authorizationChecker;

    /**
     * Constructor
     *
     * @param string $entity
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationChecker $checker
     */
    public function __construct($entity, TokenStorageInterface $tokenStorage, AuthorizationChecker $checker)
    {
        $this->entity = $entity;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $this->addCondition($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->addCondition($queryBuilder, $resourceClass);
    }

    /**
     * Add owner condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    protected function addCondition(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if ($this->entity !== $resourceClass) {
            return;
        }

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.ownerUuid = :ownerUuid', $rootAlias));

        if ($user instanceof User) {
            $queryBuilder->setParameter('ownerUuid', $user->getUuid());
        } else {
            $queryBuilder->setParameter('ownerUuid', -1);
        }
    }
}
