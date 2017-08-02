<?php

namespace Ds\Component\Security\Doctrine\ORM\QueryExtension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Ds\Component\Security\User\User;
use Ds\Component\Security\Exception\InvalidUserTypeException;

/**
 * Class AuthorizationExtension
 *
 * @package Ds\Component\Security
 */
abstract class AuthorizationExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    protected $authorizationChecker;

    /**
     * @var \Ds\Component\Security\User\User
     */
    protected $user;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationChecker $checker
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationChecker $checker)
    {
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
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    protected function applyCondition(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user instanceof User) {
            throw new InvalidUserTypeException('User type is not valid.');
        }

        $this->apply($queryBuilder, $resourceClass);
    }

    /**
     * Apply authorization condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $resourceClass
     */
    abstract protected function apply(QueryBuilder $queryBuilder, string $resourceClass);
}
