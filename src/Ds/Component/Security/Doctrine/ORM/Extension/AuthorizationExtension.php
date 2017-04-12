<?php

namespace Ds\Component\Security\Doctrine\ORM\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;

/**
 * Class AuthorizationExtension
 */
abstract class AuthorizationExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
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
        $this->applyCondition($queryBuilder, $resourceClass);
    }

    /**
     * {@inheritdoc}
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        $this->applyCondition($queryBuilder, $resourceClass);
    }

    /**
     * Apply authorization condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    protected function applyCondition(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if ($this->entity !== $resourceClass) {
            return;
        }

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return;
        }

        $this->apply($queryBuilder);
    }

    /**
     * Apply authorization condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     */
    abstract protected function apply(QueryBuilder $queryBuilder);
}
